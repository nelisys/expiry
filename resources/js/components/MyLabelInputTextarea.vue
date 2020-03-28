<template>
    <div class="form-group row mb-2">
        <label :for="id" class="col-md-3 col-form-label text-md-right font-weight-bold"
            :class="{'bg-light': label != ''}">
            {{ label }}
        </label>
        <div :class="typeof col_width == 'undefined' ? 'col-md-9' : col_width">
            <my-input-textarea
                :id="id"
                :form="form"
                :action="action"
                :readonly="readonly"
                :autofocus="autofocus"
                :placeholder="placeholder"
                :util_class="util_class"
                :input_append="input_append"></my-input-textarea>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['id', 'label', 'form', 'action', 'readonly', 'col_width', 'input_append', 'autofocus', 'placeholder', 'util_class'],
    }
</script>
