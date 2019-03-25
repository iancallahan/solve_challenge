<template>
  <div class="form-group">
    <label class="componentLabel">Biography</label>
    <vue-editor v-model="content" :editorToolbar="customToolbar"></vue-editor>
    <div class="statusBar">
      <span class="saveState"><span v-if="saved" class="saveSuccess">Saved!</span><span v-else class="saveWaiting">Not Saved</span></span>
      <span class="wordTally" v-bind:class="{'text-danger': overLimit, 'd-none':hideMax }">Words remaining: {{wordsRemaining}}</span>
    </div>
  </div>
</template>

<script>
  import { VueEditor } from 'vue2-editor'
  import axios from 'axios';

  export default {

    components: {
      VueEditor
    },

    data() {
      return {
        content: '',
        saved: true,
        loading: false,
        initialized: false,
        words: 0,
        overLimit: false,
        customToolbar: [
            ['bold', 'italic', 'underline'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
          ]
      }
    },
    computed: {
      wordsRemaining: function () {
        var tally =  this.maxWords - this.words;
        if(tally < 0) {
          this.overLimit = true;
        }
        else {
          this.overLimit = false;
        }
        return tally;
      },
      hideMax: function () {
        if(this.maxWords == 0) {
          return true;                                                                    
        }
        else {
          return false;
        }
      }
    },
    watch: {
      // whenever response changes, this function will run
      content: function () {
        this.debouncedSaveContent()
      }
    },
    created: function () {
      // _.debounce is a function provided by lodash to limit how
      // often a particularly expensive operation can be run.
      // In this case, we want to limit how often we access
      // yesno.wtf/api, waiting until the user has completely
      // finished typing before making the ajax request. To learn
      // more about the _.debounce function (and its cousin
      // _.throttle), visit: https://lodash.com/docs#debounce
      this.debouncedSaveContent = _.debounce(this.saveContent, 1000);
      this.getContent();
    },
    updated: function() {
      this.$watch('content', function(newVal, oldVal) {
        this.words = this.wordCount(newVal);
        if(oldVal != ''){
          this.saved = false;
        }
      });
    },
    methods: {
      getContent: function() {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        axios.get(this.biographyRoute)
        .then((response)  =>  {
            this.words = this.wordCount(response.data);
            this.content = response.data;
            this.initialized = true;
        }, (error)  =>  {
          this.loading = false;
        }) 
      },
      saveContent:  function () {
        if(this.words <= this.maxWords || this.hideMax){
          axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
          axios.post(this.biographyRoute, {
                bio: this.content,
                maxLength: this.maxLength,
                userId: this.userId
              })
          .then((response)  =>  {
            this.saved = true;
          }).catch((error) => {
            // Error
            if (error.response) {
                // The request was made and the server responded with a status code
                // that falls out of the range of 2xx
                alert(error.response.data.errors.bio[0]);
                this.saved = false;
            } else if (error.request) {
                // The request was made but no response was received
                // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                // http.ClientRequest in node.js
                console.log(error.request);
            } else {
                // Something happened in setting up the request that triggered an Error
                console.log('Error', error.message);
            }
            console.log(error.config);
            }); 
          }
        else {
          this.saved = false
        }
      },
      wordCount: function (text) {
        console.log("This is text:" + text);
        if(text === null){
          return 0;
        }
        if(text === '') {
          return 0;
        }
        text = text.replace(/(^\s*)|(\s*$)/gi,"");
        text = text.replace(/[ ]{2,}/gi," ");
        text = text.replace(/\n /,"\n");
        var words = text.split(' ').length;
        return words;
      }
    },
    props: {
      maxLength:{type: Number, default:5000},
      maxWords:{type: Number, default: 0},
      biographyRoute:{type: String, default: 'biography'}
    }
  }

</script>

 <style>
   [v-cloak] {
    display: none;
  }
  .statusBar {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
  }

  .saveSuccess {
    color: green;
    font-weight: bold;
  }

  .saveWaiting {
    color: red;
  }

  .componentLabel {
    margin-top: 1em;
  }

  </style>