const API_URL = 'https://apisorvete.webapptech.site/api/sorvete';
import { Alert} from 'react-native';


export const fetchSabores = async (setRegistros) => {
  try {
    const response = await fetch(API_URL);
    if (!response.ok) {
      throw new Error('Erro ao buscar o sabor');
    }
    const data = await response.json();
    console.log('Sabores recebidos da API:', data); 
    setRegistros(data.data);
  } catch (error) {
    console.error('Erro ao buscar o sabor:', error);
    throw error;
  }
};

export const createSabor = async (saborData ) => {
   try {
    const response = await fetch('https://apisorvete.webapptech.site/api/sorvete', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(saborData),
    });

    // Verifica se a API retornou status 204 (sem conteúdo)
    if (response.status === 204) {
      Alert.alert('Sucesso!', 'Cadastro realizado com sucesso!');
      return {}; // Retorna um objeto vazio para evitar erro
    }

    // Caso a API retorne conteúdo, tentamos converter para JSON
    const textResponse = await response.text();
    console.log('Resposta bruta da API:', textResponse);

    let responseData;
    try {
      responseData = JSON.parse(textResponse);
    } catch (error) {
      console.warn('A resposta não é um JSON válido.');
      responseData = null;
    }

    if (!response.ok || !responseData) {
      throw new Error(responseData?.message || 'Erro desconhecido na API');
    }

    return responseData;
  } catch (error) {
    console.error('Erro ao cadastrar o sabor:', error.message);
    Alert.alert('Erro ao cadastrar', `Detalhes: ${error.message}`);
    return null;
  }
};


export const deleteSabor = async (saborId, setRegistros) => {
   try {
    const response = await fetch(`https://apisorvete.webapptech.site/api/sorvete/${saborId}`, {
      method: 'DELETE',
    });

    // Verifica se a resposta foi bem-sucedida
    if (response.ok) {
      const responseData = await response.json(); // Obtém o JSON da resposta

      if (responseData.success) {
        Alert.alert('Sucesso!', responseData.message);
        // Atualiza a lista localmente, removendo o livro excluído
setRegistros((prevRegistros) => {
  const novaLista = prevRegistros.filter((sabores) => sabores.codigo != saborId);
  console.log('Nova lista de sabores:', novaLista);
  return novaLista;
});

      } else {
        Alert.alert('Erro', responseData.message);
      }
    } else {
      // Caso a resposta não seja ok, tenta processar a mensagem de erro
      const textResponse = await response.text();
      let responseData = null;

      try {
        responseData = JSON.parse(textResponse); // tenta converter o texto para JSON
      } catch (error) {
        console.warn('A resposta não é um JSON válido.');
      }

      throw new Error(responseData?.message || 'Erro desconhecido ao excluir o sabor');
    }
  } catch (error) {
    console.error('Erro ao excluir sabor:', error.message);
    Alert.alert('Erro ao excluir', `Detalhes: ${error.message}`);
  }
};

export const updateSabor = async (saborId, updatedData, navigation) => {
  try {
    const response = await fetch(`https://apisorvete.webapptech.site/api/sorvete/${saborId}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(updatedData),
    });

    console.log('Dados enviados:', updatedData);

    if (response.status === 200) {
      Alert.alert('Sucesso!', 'Sabor atualizado com sucesso!');
      navigation.navigate('Home'); // Volta para a tela principal
    } else {
      const textResponse = await response.text();
      let responseData;
      try {
        responseData = JSON.parse(textResponse);
      } catch (error) {
        console.warn('A resposta não é um JSON válido.');
        responseData = null;
      }

      throw new Error(responseData?.message || 'Erro desconhecido ao atualizar o sabor');
    }
  } catch (error) {
    console.error('Erro ao atualizar o sabor:', error.message);
    Alert.alert('Erro ao atualizar', `Detalhes: ${error.message}`);
  }
};
