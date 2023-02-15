import axios from "axios";

export function getProducts({commit, state}) {
    commit('setProducts', [true])
    url = url || '/api/products'
    const params = {
        per_page: state.products.limit,

    }
    return axios.get(url, {
        params: {
            ...params,
            search, per_page, sort_field, sort_direction
        }
    })
    .then ((response) => {
        commit('setProducts', [false, response.data])
    })
    .catch(() => {
        commit('setProducts', [false])
    })
}