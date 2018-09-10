<template>
  <div class="row">
    <div class="col-lg-8 m-auto">
      <card :title="$t('register')">
        <h2 v-if="isSend">Войдите по ссылке отправленной на почту</h2>

        <form @submit.prevent="register" @keydown="form.onKeydown($event)">
          <!-- Name -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
            <div class="col-md-7">
              <input v-model="form.name" type="text" name="name" class="form-control"
                :class="{ 'is-invalid': form.errors.has('name') }">
              <has-error :form="form" field="name"/>
            </div>
          </div>

          <!-- Email -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
            <div class="col-md-7">
              <input v-model="form.email" type="email" name="email" class="form-control"
                :class="{ 'is-invalid': form.errors.has('email') }">
              <has-error :form="form" field="email"/>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-7 offset-md-3 d-flex">
              <!-- Submit Button -->
              <v-button :loading="form.busy">
                {{ $t('register') }}
              </v-button>

              <!-- GitHub Register Button -->
              <login-with-github/>
            </div>
          </div>
        </form>
      </card>
    </div>
  </div>
</template>

<script>
import Form from 'vform'
import LoginWithGithub from '~/components/LoginWithGithub'

export default {
  middleware: 'guest',

  components: {
    LoginWithGithub
  },

  metaInfo () {
    return { title: this.$t('register') }
  },

  data: () => ({
    form: new Form({
      name: '',
      email: ''
    }),
    isSend: false
  }),

  methods: {
    async register () {
      // Register the user.
      await this.form.post('/api/register')

      // Log in the user.
      const { data } = await this.form.post('/api/login')

      if (!data.error) {
        this.isSend = true
      }
    }
  }
}
</script>