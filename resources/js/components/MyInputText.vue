<template>
    <div class="input-group">
        <input type="text"
            :id="id"
            :name="id"
            :class="formClass"
            :autofocus="autofocus"
            :readonly="isReadonly"
            :tabindex="tabindex"
            :value="inputValue"
            :placeholder="displayPlaceholder"
            @input="onInput($event)"
            @keydown.enter="onEnter"
            @blur="onBlur"
            :dusk="dusk"
            >

        <div v-if="input_append && ! isReadonly" class="input-group-append">
            <div class="input-group-text">{{ input_append }}</div>
        </div>

        <div class="invalid-feedback" v-if="form.errors.has(id)"
            v-text="form.errors.get(id)"></div>
    </div>
</template>

<script>
    export default {
        props: ['id', 'autofocus', 'form', 'action', 'readonly', 'mode', 'input_append', 'placeholder', 'util_class', 'dusk'],

        methods: {
            onInput(e) {
                this.form[this.id] = e.target.value;
                this.$emit('input', e.target.value);
            },

            onEnter(e) {
                this.$emit('enter')
            },

            onBlur(e) {
                this.$emit('blur')
            },
        },

        computed: {
            inputValue: function() {
                if (this.action == 'show' && this.input_append) {
                    return this.form[this.id] + ' ' + this.input_append;
                }

                return this.form[this.id];
            },

            displayPlaceholder: function() {
                if (this.action == 'show' || this.action == 'delete') {
                    return '';
                }

                return this.placeholder;
            },

            isReadonly: function() {
                return this.readonly || this.action == 'show' || this.action == 'delete';
            },

            tabindex: function() {
                if (this.isReadonly) {
                    return -1;
                }

                return '';
            },

            formClass: function () {
                let returnClass;
                let util_classes;

                if (!! this.mode) {
                    if (this.mode == 'show') {
                        returnClass = {
                            'is-invalid': this.form.errors.has(this.id),
                            'form-control-plaintext': true,
                        }
                    } else if (this.mode == 'edit') {
                        returnClass = {
                            'is-invalid': this.form.errors.has(this.id),
                            'form-control': true,
                        }
                    }
                } else {
                    returnClass = {
                        'is-invalid': this.form.errors.has(this.id),
                        'form-control': this.action != 'show' && this.action != 'delete' && ! this.readonly,
                        'form-control-plaintext': this.action == 'show' || this.action == 'delete' || this.readonly,
                    }
                }

                if (this.util_class) {
                    returnClass = Object.assign(returnClass, this.util_class);

                }

                return returnClass;
            }
        },
    }
</script>
