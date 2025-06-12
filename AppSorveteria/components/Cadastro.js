import React, { useState } from 'react';
import { View, TextInput, Button, Alert } from 'react-native';
import { createSabor } from './Api';
  
export default function Cadastro({ navigation }) {
  const [registro, setRegistros] = useState([]);
  const [sabor, setSabor] = useState('');
  const [descricao, setDescricao] = useState('');

const [selectedSaborId, setSelectedSaborId] = useState(null);

  const handleSubmit = async () => {
      if (!sabor || !descricao ) {
    Alert.alert('Atenção', 'Preencha todos os campos antes de cadastrar.');
    return;
  }

  const newSabor = { sabor, descricao };

  if (selectedSaborId) {
    // Se um livro estiver selecionado para edição, chamamos a função de update
    await updateSabor(selectedSaborId, newSabor);
    setSelectedSaborId(null); // Limpa a seleção após edição
  } else {
    // Se não, chamamos a função de criação de livro
    const addedSabor = await createSabor(newSabor);
    if (addedSabor) {
      Alert.alert('Sucesso!', 'Cadastro realizado com sucesso!', [
        { text: 'OK', onPress: () => navigation.navigate('Home') },
  
      ]);
    }
  }

  // Limpa os campos do formulário
  setSabor('');
  setDescricao('');
  };

  return (
    <View>
      <TextInput
        placeholder="Nome do sabor"
        value={sabor}
        onChangeText={setSabor}
      />
      <TextInput
        placeholder="Descrição"
        value={descricao}
        onChangeText={setDescricao}
      />
    
      <Button title="Cadastrar" onPress={handleSubmit} />
    </View>
  );
}