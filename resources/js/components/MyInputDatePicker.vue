<template>
    <div class="input-group">
        <datepicker ref="refDatepicker" :input-class="formClass" :name="id" :value="form[id]"
            placeholder="Select Date"
            :bootstrap-styling="true"
            :disabled="isReadonly"
            @input="onInput($event)"
            @keydown.enter="onEnter"
            :format="dateFormat">
            <template slot="afterDateInput" v-if="action == 'create' || action == 'edit' || action == 'move'">
                <span class="input-group-append" @click="showCalendar">
                    <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                    </span>
                </span>
            </template>
        </datepicker>

        <div class="invalid-feedback" v-if="form.errors.has(id)"
            v-text="form.errors.get(id)"></div>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';

    export default {
        components: {
            Datepicker
        },

        props: ['id', 'autofocus', 'form', 'action', 'readonly', 'mode', 'input_append'],

        data() {
            return {
                inputValue: '',
            }
        },

        methods: {
            showCalendar () {
                this.$refs.refDatepicker.showCalendar();
            },

            onInput(e) {
                this.form[this.id] = moment(e).format('YYYY-MM-DD');
                this.$emit('input', moment(e).format('YYYY-MM-DD'));
            },

            onEnter(e) {
                this.$emit('enter')
            },

            dateFormat(date) {
                return moment(date).format('YYYY-MM-DD');
            },
        },

        computed: {
            isReadonly: function() {
                return this.readonly || this.action == 'show' || this.action == 'delete';
            },
            formClass: function () {
                if (!! this.mode) {
                    if (this.mode == 'show') {
                        return {
                            'is-invalid': this.form.errors.has(this.id),
                            'form-control-plaintext': true,
                        }
                    } else if (this.mode == 'edit') {
                        return {
                            'is-invalid': this.form.errors.has(this.id),
                            'form-control': true,
                        }
                    }
                }

                return {
                    'is-invalid': this.form.errors.has(this.id),
                    'form-control': this.action != 'show' && this.action != 'delete' && ! this.readonly,
                    'form-control-plaintext': this.action == 'show' || this.action == 'delete' || this.readonly,
                }
            }
        },
    }
</script>
