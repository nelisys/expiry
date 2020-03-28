<template>
    <div class="form-group row mb-2">
        <label :for="id" class="col-md-3 col-form-label text-md-right font-weight-bold"
            :class="{'bg-light': label != ''}">
            {{ label }}
        </label>
        <div :class="typeof col_width == 'undefined' ? 'col-md-9' : col_width">
            <my-input-date-picker :id="id" :form="form" :action="action" :readonly="readonly" :input_append="input_append"></my-input-date-picker>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['id', 'label', 'form', 'action', 'readonly', 'col_width', 'input_append'],
    }
</script>
