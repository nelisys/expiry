<template>
    <div :class="'alert alert-' + alertColor" v-if="show">
        <strong>{{ alertType }}</strong> {{ body }}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
</template>

<script>
    export default {
        props: ['message', 'level'],

        data() {
            return {
                body: '',
                alert: 'success',
                show: false,
            }
        },

        created() {
            if (this.message) {
                this.flash(this.message, this.level);
            }

            window.events.$on('flash', (message, level) => {
                this.flash(message, level);
            })
        },

        methods: {
            flash(message, level) {
                this.body = message;
                this.show = true;

                if (level) {
                    if (level == 'error') {
                        this.alertType = 'Error';
                        this.alertColor = 'danger';
                    } else if (level == 'warning') {
                        this.alertType = 'Warning';
                        this.alertColor = 'warning';
                    } else {
                        this.alertType = '';
                        this.alertColor = 'primary'
                    }
                } else {
                    this.alertType = 'Success';
                    this.alertColor = 'success';
                }

                this.hide();
            },
            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 3000)
            }
        }

    }
</script>