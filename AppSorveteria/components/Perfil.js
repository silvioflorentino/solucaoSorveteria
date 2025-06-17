import React, { useEffect, useState } from 'react';
import { View, Text, StyleSheet, ActivityIndicator, TextInput, Button, Alert, Image } from 'react-native';
import * as ImagePicker from 'expo-image-picker';
import { auth } from './Firebase';
import { getFirestore, doc, getDoc, updateDoc } from 'firebase/firestore';

const PerfilScreen = () => {
  const [userData, setUserData] = useState(null);
  const [loading, setLoading] = useState(true);
  const [isEditing, setIsEditing] = useState(false);
  const [name, setName] = useState('');
  const [bio, setBio] = useState('');
  const db = getFirestore();

  useEffect(() => {
    const fetchUserData = async () => {
      const user = auth.currentUser;
      if (user) {
        const docRef = doc(db, 'users', user.uid);
        const docSnap = await getDoc(docRef);
        if (docSnap.exists()) {
          const data = docSnap.data();
          setUserData(data);
          setName(data.name || '');
          setBio(data.bio || '');
        }
      }
      setLoading(false);
    };

    fetchUserData();
  }, []);

  const handleSave = async () => {
    try {
      const user = auth.currentUser;
      if (user) {
        const docRef = doc(db, 'users', user.uid);
        await updateDoc(docRef, { name, bio });
        setUserData({ ...userData, name, bio });
        setIsEditing(false);
        Alert.alert('Sucesso', 'Dados atualizados com sucesso!');
      }
    } catch (error) {
      Alert.alert('Erro', 'Não foi possível atualizar os dados.');
    }
  };

  const pickImageAndUpload = async () => {
    try {
      const result = await ImagePicker.launchImageLibraryAsync({
        mediaTypes: ImagePicker.MediaTypeOptions.Images,
        allowsEditing: true,
        quality: 1,
        base64: true,
      });
      
      if (!result.canceled) {
        const base64Img = `data:image/jpg;base64,${result.assets[0].base64}`;
        // Dados para o Cloudinary
        const data = {
          file: base64Img,
          upload_preset: 'preset_publico',
          cloud_name: 'dgsffmd9f',
        };
        
        const res = await fetch('https://api.cloudinary.com/v1_1/dgsffmd9f/image/upload', {
          method: 'POST',
          body: JSON.stringify(data),
          headers: {
            'content-type': 'application/json',
          },
        });
        
        const json = await res.json();
  
        if (json.secure_url) {
          const user = auth.currentUser;
          await updateDoc(doc(db, 'users', user.uid), {
            photoURL: json.secure_url,
          });
          // Atualiza os dados do usuário localmente
          setUserData(prev => ({ ...prev, photoURL: json.secure_url }));
          Alert.alert('Sucesso', 'Foto de perfil atualizada!');
        } else {
          Alert.alert('Erro', 'Erro ao enviar imagem. Verifique se o preset está correto.');
        }
      }
    } catch (error) {
      console.error(error);
      Alert.alert('Erro', 'Algo deu errado ao tentar fazer o upload.');
    }
  };

  return (
    <View style={styles.container}>
      {loading ? (
        <ActivityIndicator size="large" color="#0000ff" />
      ) : userData ? (
        <>
          <Text style={styles.title}>Perfil do Usuário</Text>
          
          {/* Exibe a foto se existir */}
          {userData.photoURL ? (
            <Image
              source={{ uri: userData.photoURL }}
              style={styles.profileImage}
            />
          ) : (
            <Text style={styles.info}>Nenhuma foto cadastrada.</Text>
          )}
          <Button title="Editar Foto de Perfil" onPress={pickImageAndUpload} />

          {isEditing ? (
            <>
              <TextInput
                style={styles.input}
                value={name}
                onChangeText={setName}
                placeholder="Nome"
              />
              <TextInput
                style={styles.input}
                value={bio}
                onChangeText={setBio}
                placeholder="Bio"
              />
              <Button title="Salvar" onPress={handleSave} />
              <Button title="Cancelar" onPress={() => setIsEditing(false)} color="#888" />
            </>
          ) : (
            <>
              <Text style={styles.info}>Nome: {userData.name}</Text>
              <Text style={styles.info}>Bio: {userData.bio}</Text>
              <Button title="Editar" onPress={() => setIsEditing(true)} />
            </>
          )}
        </>
      ) : (
        <Text>Usuário não encontrado.</Text>
      )}
    </View>
  );
};

const styles = StyleSheet.create({
  container: { 
    flex: 1, 
    justifyContent: 'center', 
    alignItems: 'center', 
    padding: 20 
  },
  title: { 
    fontSize: 24, 
    fontWeight: 'bold', 
    marginBottom: 10 
  },
  info: { 
    fontSize: 18, 
    marginBottom: 5 
  },
  input: {
    width: '100%',
    borderWidth: 1,
    padding: 10,
    marginVertical: 5,
    fontSize: 16,
    borderRadius: 5,
  },
  profileImage: {
    width: 120,
    height: 120,
    borderRadius: 60,
    marginBottom: 10,
  },
});

export default PerfilScreen;
