<template>
    <div>
        <button class="btn btn-info" @click="Show()">Оставить комментарий</button>

        <div v-if="showform">
            <form @submit.prevent="saveComment">
                <div v-if="errors.length">
                    <b>Пожалуйста исправьте указанные ошибки:</b>
                    <ul>
                        <li v-for="error in errors">{{ error }}</li>
                    </ul>
                </div>
                <input type="hidden" class="form-control" v-model="id">
                <input type="hidden" class="form-control" v-model="title">
                <p>Комментарий:<br>
                    <textarea class="form-control" v-model="comment.body" rows="5"></textarea>
                </p>
                <br>
                <button class="btn btn-primary" @click=" checkForm();">Добавить комментарий</button>
            </form>
        </div>
    </div>
</template>
<script>
    import Event from '../event.js';

    export default {
        props: ['id', 'title'],
        data() {
            return {
                comment: {},
                postData: {},
                showform: false,
                errors: [],

            }
        },
        methods: {
            saveComment() {
                axios.post('/api/auth/comment/savesub', {
                    body: this.comment.body,
                    parent_id: this.id,
                    title: this.title,
                }).catch(e => {
                    console.log(e);
                });
                Event.$emit('added_comment', this.postData);
                this.comment = {};

            },
            Show: function () {
                this.showform = !this.showform
            },
            checkForm: function () {
                if (this.comment.body) {
                    return true;
                }
                this.errors = [];
                if (!this.comment.body) {
                    this.errors.push('Боди не может быть налл');
                }

            }

        }
    }
</script>