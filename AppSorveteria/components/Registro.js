import React, { useState } from 'react';
import { View, Text, TextInput, Button, StyleSheet, Alert } from 'react-native';
import { createUserWithEmailAndPassword } from 'firebase/auth';
import { setDoc, doc } from 'firebase/firestore';
import { auth, db } from './Firebase';

const RegistroScreen = ({ navigation }) => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [name, setName] = useState('');
  const [bio, setBio] = useState('');

  const handleRegister = async () => {
    try {
      const userCredential = await createUserWithEmailAndPassword(auth, email, password);
      const user = userCredential.user;

      // Salvar nome e bio no Firestore
      await setDoc(doc(db, 'users', user.uid), {
        name,
        bio
      });

      Alert.alert('Sucesso! 🎉', 'Usuário cadastrado com sucesso!', [
        { text: 'OK', onPress: () => navigation.replace('Home') }
      ]);
    } catch (err) {
      Alert.alert('Erro', 'Não foi possível cadastrar. Tente novamente.');
    }
  };

  return (
    <View style={styles.container}>
      <Text>Cadastro</Text>
      <TextInput style={styles.input} placeholder="Nome" value={name} onChangeText={setName} />
      <TextInput style={styles.input} placeholder="Bio" value={bio} onChangeText={setBio} />
      <TextInput style={styles.input} placeholder="Email" value={email} onChangeText={setEmail} />
      <TextInput style={styles.input} placeholder="Senha" secureTextEntry value={password} onChangeText={setPassword} />
      <Button title="Cadastrar" onPress={handleRegister} />
    </View>
  );
};

const styles = StyleSheet.create({
  container: { flex: 1, justifyContent: 'center', alignItems: 'center' },
  input: { width: '80%', padding: 10, borderWidth: 1, marginVertical: 5 },
});

export default RegistroScreen;
