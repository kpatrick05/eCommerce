import { createStore } from 'vuex'
import axios from 'axios';
import state from './state';
import * as actions from './actions'
import * as mutations from './mutations'

const store = createStore({
    state,
    getters: {},
    actions,
    mutations,
});

export default store;