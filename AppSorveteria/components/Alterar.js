import React, { useState } from 'react';
import { View, TextInput, Button, Alert } from 'react-native';
import { updateSabor } from './Api';

export default function Alterar({ route, navigation }) {
  const { sabores } = route.params;
  const [sabor, setSabor] = useState(sabores.sabor);
  const [descricao, setDescricao] = useState(sabores.descricao);

const handleUpdate = () => {
  const updatedData = {
    sabor,
    descricao,
  };

  Alert.alert(
    'Confirmação',
    'Tem certeza de que deseja alterar este sabor?',
    [
      { text: 'Cancelar', style: 'cancel' },
      {
        text: 'Alterar',
        onPress: () => updateSabor(sabores.id, updatedData, navigation), 
      },
    ]
  );
};


  return (
    <View>
      <TextInput
        placeholder="Sabor"
        value={sabor}
        onChangeText={setSabor}
      />
      <TextInput
        placeholder="Descrição"
        value={descricao}
        onChangeText={setDescricao}
      />

      <Button title="Alterar" onPress={handleUpdate} />
    </View>
  );
}