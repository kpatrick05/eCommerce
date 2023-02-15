import { ref } from "vue";
import axios from 'axios';
export function fetch(id) {

axios.get('/api/fetch/' +  id)
  .then(response => {
    data.value = response.data;
  })
  .catch(error => {
    console.log(error);
  });

}