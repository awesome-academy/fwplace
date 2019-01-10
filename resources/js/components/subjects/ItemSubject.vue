<template>
    <div @dblclick="editType" v-if="!editing" v-html="type"></div>
    <input v-else type="text" v-model="type" @blur="doneEdit" @keyup.enter="doneEdit" @keyup.esc="cancelEdit" v-focus>
</template>
<script type="text/javascript">
export default {
    props: {
        content: {
            required: true
        },

        id: {
            required: true
        },

        column: {
            required: true
        }
    },

    directives: {
        focus: {
            inserted: function(el) {
                el.focus();
            }
        }
    },

    data() {
        return {
            editing: false,
            type: this.content,
            idType: this.id,
            columnType: this.column
        };
    },

    methods: {
        editType() {
            this.editing = true;
        },

        doneEdit() {
            this.editing = false;
            this.$emit('finishedEdit', {
                id: this.idType,
                type: this.type,
                column: this.columnType
            });
        }
    }
};
</script>
