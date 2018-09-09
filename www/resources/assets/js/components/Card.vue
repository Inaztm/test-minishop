<template>
  <div class="card">
    <div v-if="title" class="card-header d-flex align-items-center justify-content-between">
      <span>{{ title }}</span>
      <slot name="header_action" />
    </div>

    <div class="card-body">
      <slot/>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Card',

  props: ['title']
}
</script>
