<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Firebase Live Chat</title>
  <!-- Include Firebase SDK -->
  <script src="https://www.gstatic.com/firebasejs/9.5.0/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/9.5.0/firebase-auth.js"></script>
  <script src="https://www.gstatic.com/firebasejs/9.5.0/firebase-database.js"></script>
</head>
<body>
  <div id="chat-container">
    <div id="chat-messages"></div>
    <input type="text" id="message-input" placeholder="Type your message...">
    <button id="send-button">Send</button>
  </div>
  
  <script>
    // Initialize Firebase
    const firebaseConfig = {
  apiKey: "AIzaSyDeS_h1HG3G2tmj1iOK54PCSC0LuMFxe7Y",
  authDomain: "test1-c5f44.firebaseapp.com",
  projectId: "test1-c5f44",
  storageBucket: "test1-c5f44.appspot.com",
  messagingSenderId: "864182836660",
  appId: "1:864182836660:web:2c495517048794929966e1"
};
    firebase.initializeApp(firebaseConfig);
    
    // Reference to the Realtime Database
    const db = firebase.database();
    
    // Reference to chat messages
    const chatMessagesRef = db.ref("chat_messages");
    
    const messageInput = document.getElementById("message-input");
    const sendButton = document.getElementById("send-button");
    const chatMessagesDiv = document.getElementById("chat-messages");
    
    // Send message
    sendButton.addEventListener("click", () => {
  console.log("Send button clicked"); // Debugging statement
  const message = messageInput.value;
  if (message.trim() !== "") {
    chatMessagesRef.push({
      text: message,
      timestamp: firebase.database.ServerValue.TIMESTAMP
    });
    messageInput.value = "";
  }
});

    
    // Listen for new messages
    chatMessagesRef.on("child_added", snapshot => {
      const message = snapshot.val();
      const messageDiv = document.createElement("div");
      messageDiv.textContent = message.text;
      chatMessagesDiv.appendChild(messageDiv);
    });
  </script>
</body>
</html>
