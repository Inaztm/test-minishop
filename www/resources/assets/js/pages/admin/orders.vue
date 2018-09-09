<template>
  <div class="table-responsive">
    <!-- Modal -->
    <div
      class="modal fade"
      id="order_edit"
      tabindex="-1"s
      role="dialog"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit order</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form
                @submit.prevent="edit"
                @keydown="editForm.onKeydown($event)">
                <alert-success :form="editForm" message="Updated"/>

                <div class="form-group">
                  <label>Status</label>
                  <select
                    class="form-control"
                    v-model="editForm.status">
                    <option
                      v-for="status in statuts"
                      :key="status.key"
                      :value="status.key">
                      {{ status.name }}
                    </option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="exampleFormControlInput1">Name</label>
                  <input
                    type="text"
                    class="form-control"
                    :class="{ 'is-invalid': editForm.errors.has('name') }"
                    v-model="editForm.name">
                  <has-error :form="editForm" field="name"/>
                </div>

                <div class="form-group">
                  <label>Email address</label>
                  <input
                    type="email"
                    class="form-control"
                    :class="{ 'is-invalid': editForm.errors.has('email') }"
                    v-model="editForm.email">
                  <has-error :form="editForm" field="email"/>
                </div>

                <div class="form-group">
                  <label>Phone</label>
                  <input
                    type="text"
                    class="form-control"
                    :class="{ 'is-invalid': editForm.errors.has('phone') }"
                    v-model="editForm.phone">
                  <has-error :form="editForm" field="phone"/>
                </div>

                <div class="form-group">
                  <label>Products</label>
                  <select
                    multiple
                    class="form-control"
                    :class="{ 'is-invalid': editForm.errors.has('products') }"
                    v-model="editForm.products">
                    <option
                      v-for="product in products"
                      :key="product.id"
                      :value="product.id">
                      {{ product.name }} - ${{ product.price }}
                    </option>
                  </select>
                  <has-error :form="editForm" field="products"/>
                </div>

                <div class="form-group">
                  <label>Comment</label>
                  <textarea
                    class="form-control"
                    :class="{ 'is-invalid': editForm.errors.has('comment') }"
                    rows="3"
                    v-model="editForm.comment"></textarea>
                  <has-error :form="editForm" field="comment"/>
                </div>

                <div class="form-group">
                  <label>Total price</label>
                  <b>${{ editForm.total_price }}</b>
                </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-primary mb-2">Update</button>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Status</th>
          <th scope="col">Name</th>
          <th scope="col">Phone</th>
          <th scope="col">Total price</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="order in orders" :key="order.id">
          <td>{{ order.status }}</td>
          <td>{{ order.name }}</td>
          <td>{{ order.phone }}</td>
          <td>{{ order.total_price }}</td>
          <td>
            <button
              data-toggle="modal"
              data-target="#order_edit"
              class="btn btn-primary btn-sm"
              @click="changeEdit(order)">
              Edit
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import Form from 'vform'
import { mapGetters } from 'vuex'

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('settings') }
  },

  data: () => ({
    editForm: new Form({
      status: '',
      email: '',
      name: '',
      total_price: '',
      phone: '',
      comment: '',
      products: []
    }),
    statuts: [
      { key: 'moderation', name: 'Moderation' },
      { key: 'view', name: 'View' },
      { key: 'success', name: 'Success' }
    ],
    orderEdit: 0
  }),

  computed: mapGetters({
    orders: 'orders/orders',
    products: 'products/products'
  }),

  created () {
    this.$store.dispatch('products/fetchProducts')
    this.$store.dispatch('orders/fetchOrders')
  },

  methods: {
    changeEdit (data) {
      this.orderEdit = data.id

      this.editForm.keys().forEach(key => {
        if (key == 'products') {
          let ids = []

          data.products.map(product => ids.push(product.id))

          this.editForm.products = ids
        } else {
          this.editForm[key] = data[key]
        }
      })
    },

    async edit () {
      console.log(this.editForm)

      await this.editForm.post('/api/orders/update/' + this.orderEdit)
      
      this.orderEdit = 0
      this.$store.dispatch('orders/fetchOrders')
    },
  },

  watch: {
    'editForm.products': function(newValue, oldValue) {
      if (newValue.length > 0) {
        this.editForm.total_price = 0
      }

      newValue.map(id => {
        let product = this.products.filter(product => product.id == id)[0]

        this.editForm.total_price += parseFloat(product.price)
      })
    }
  }
}
</script>