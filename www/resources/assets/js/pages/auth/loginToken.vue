<script>

export default {
  middleware: 'guest',

  metaInfo () {
    return { title: this.$t('login') }
  },

  data: () => ({
    remember: true
  }),

  methods: {
    async login () {
      // Submit the form.
      const { data } = await this.form.post('/api/login/' + this.$route.params.token)

      // Save the token.
      this.$store.dispatch('auth/saveToken', {
        token: data.token,
        remember: this.remember
      })

      // Fetch the user.
      await this.$store.dispatch('auth/fetchUser')

      // Redirect home.
      this.$router.push({ name: 'welcome' })
    }
  }
}
</script>