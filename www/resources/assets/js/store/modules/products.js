import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  products: [],
  product: {}
}

// getters
export const getters = {
  products: state => state.products,
  product: state => state.product
}

// mutations
export const mutations = {

  [types.FETCH_PRODUCTS_SUCCESS] (state, { products }) {
    state.products = products
  },

  [types.FETCH_PRODUCTS_FAILURE] (state) {
  },

  [types.FETCH_PRODUCT_SUCCESS] (state, { product }) {
    state.product = product
  },

  [types.FETCH_PRODUCT_FAILURE] (state) {
  }

}

// actions
export const actions = {

  async fetchProducts ({ commit }) {
    try {
      const { data } = await axios.get('/api/products')

      commit(types.FETCH_PRODUCTS_SUCCESS, { products: data })
    } catch (e) {
      commit(types.FETCH_PRODUCTS_FAILURE)
    }
  },

  async fetchProduct ({ commit }, id) {
    try {
      const { data } = await axios.get('/api/products/' + id)

      commit(types.FETCH_PRODUCT_SUCCESS, { product: data })
    } catch (e) {
      commit(types.FETCH_PRODUCT_FAILURE)
    }
  }

}
