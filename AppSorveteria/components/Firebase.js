import { initializeApp } from 'firebase/app';
import { getAuth } from 'firebase/auth';
import { getFirestore } from 'firebase/firestore';


const firebaseConfig = {
  apiKey: "AIzaSyCwLqIvwCcVFErsjWNF2zbjymW1wL4qA8Y",
  authDomain: "acessobd-45131.firebaseapp.com",
  projectId: "acessobd-45131",
  storageBucket: "acessobd-45131.firebasestorage.app",
  messagingSenderId: "987014044413",
  appId: "1:987014044413:web:5421bb30424cb3b5723c94"
};


const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
const db = getFirestore(app);

export { auth, db };