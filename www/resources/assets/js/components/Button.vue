<template>
  <button :type="nativeType" :disabled="loading" class="btn" :class="{
    [`btn-${type}`]: true,
    'btn-block': block,
    'btn-lg': large,
    'btn-sm': small,
    'btn-loading': loading
  }">
    <slot/>
  </button>
</template>

<script>
export default {
  name: 'VButton',

  props: {
    type: {
      type: String,
      default: 'primary'
    },

    nativeType: {
      type: String,
      default: 'submit'
    },

    loading: {
      type: Boolean,
      default: false
    },

    block: Boolean,
    large: Boolean,
    small: Boolean
  }
}
</script>
