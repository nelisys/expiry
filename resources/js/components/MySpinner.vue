<template>
    <div v-if="open">
        <div class="modal-backdrop focus fade show"></div>
        <div class="modal fade show" style="display: block" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background-color: transparent; border: none; align; text-align: center;">
                    <div class="modal-header" style="border: none">
                        <button type="button" class="close" data-dismiss="modal" @click="open = false">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        loading...
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: [
            'open'
        ],
    }
</script>