<template>
    <div>
      <textarea v-model="textInput" rows="5" cols="50"></textarea>
      <button @click="getTopWords">Get Top Words</button>
      <ul>
        <li v-for="word in topWords" :key="word">{{ word }}</li>
      </ul>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        textInput: '',
        topWords: []
      };
    },
    methods: {
      getTopWords() {
        // Remove punctuation and convert text to lowercase
        let text = this.textInput.toLowerCase().replace(/\W+/g, ' ');
        
        // Split the text into individual words
        let words = text.split(' ');
        
        // Create an object to store word frequencies
        let wordFreq = {};
        
        // Count the frequency of each word
        words.forEach(word => {
          wordFreq[word] = (wordFreq[word] || 0) + 1;
        });
        
        // Sort the words based on their frequencies
        let sortedWords = Object.keys(wordFreq).sort((a, b) => wordFreq[b] - wordFreq[a]);
        
        // Get the top 10 words
        this.topWords = sortedWords;
      }
    }
  };
  </script>