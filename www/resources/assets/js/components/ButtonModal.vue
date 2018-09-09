<template>
    <span>
        <!-- Button trigger modal -->
        <button
            type="button"
            class="btn btn-primary"
            :class="{ 'btn-sm': small }"
            data-toggle="modal"
            :data-target="'#' + idModal">
                {{ title }}
        </button>

        <!-- Modal -->
        <div
            class="modal fade"
            :id="idModal"
            tabindex="-1"
            role="dialog"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ title }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <slot/>
                    </div>
                    <div class="modal-footer" v-if="isFooter">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <slot name="footer" />
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>

<script>
export default {
  name: 'ButtonModal',

  props: {
    idModal: {
      type: String,
      default: 'modalll'
    },
    
    title: {
      type: String,
      default: null
    },

    nativeType: {
      type: String,
      default: 'submit'
    },

    small: Boolean,

    isFooter: Boolean
  }
}
</script>
