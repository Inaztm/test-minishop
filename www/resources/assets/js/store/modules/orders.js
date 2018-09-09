import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  orders: [],
  order: {}
}

// getters
export const getters = {
  orders: state => state.orders,
  order: state => state.order
}

// mutations
export const mutations = {

  [types.FETCH_ORDERS_SUCCESS] (state, { orders }) {
    state.orders = orders
  },

  [types.FETCH_ORDERS_FAILURE] (state) {
  },

  [types.FETCH_ORDER_SUCCESS] (state, { order }) {
    state.order = order
  },

  [types.FETCH_ORDER_FAILURE] (state) {
  }

}

// actions
export const actions = {

  async fetchOrders ({ commit }) {
    try {
      const { data } = await axios.get('/api/orders')

      commit(types.FETCH_ORDERS_SUCCESS, { orders: data })
    } catch (e) {
      commit(types.FETCH_ORDERS_FAILURE)
    }
  },

  async fetchOrder ({ commit }, id) {
    try {
      const { data } = await axios.get('/api/orders/' + id)

      commit(types.FETCH_PRODUCT_SUCCESS, { order: data })
    } catch (e) {
      commit(types.FETCH_PRODUCT_FAILURE)
    }
  }

}
