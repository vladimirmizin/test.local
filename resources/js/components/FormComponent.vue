<template>
    <div>
        <form id="field" @submit.prevent="saveComment">
            <div v-if="errors.length">
                <b>Пожалуйста исправьте указанные ошибки:</b>
                <ul>
                    <li v-for="error in errors">{{ error }}</li>
                </ul>
            </div>
            <p>Тема<br>
                <input type="text" class="form-control" v-model="comment.title">
            <p>Комментарий:<br>
                <textarea class="form-control" v-model="comment.body" rows="5"></textarea>
            </p>
            <br>
            <button class="btn btn-primary" @click=" checkForm();">Добавить комментарий</button>
        </form>
    </div>
</template>
<script>
    import Event from '../event.js';

    export default {
        data() {
            return {
                errors: [],
                comment: {},
                postData: {},
            }
        },

        methods: {
            saveComment() {
                axios.post('api/auth/comment/save', this.comment).then(res => {
                    this.postData = res.data;
                    Event.$emit('added_comment', this.postData);
                }).catch(e => {
                    console.log(e);
                });
                console.log(this.comment, 'comment')
                //this.comment.body = '';
                //this.comment.title = '';
                this.comment = {};
            },
            checkForm: function () {
                if (this.comment.title && this.comment.body) {
                    return true;
                }
                this.errors = [];

                if (!this.comment.title) {
                    this.errors.push('Тайтл не может быть налл');
                }
                if (!this.comment.body) {
                    this.errors.push('Боди не может быть налл');
                }

            }

        }
    }
</script>