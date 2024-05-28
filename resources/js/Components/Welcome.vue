<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4>Shorten URL</h4>
            </div>
            <div class="card-body">
                <div v-if="errors">
                    <div class="alert alert-danger" v-for="error in errors" :key="error">
                    <span v-for="message in error">
                        {{ message }}
                    </span>
                    </div>
                </div>
                <form @submit.prevent="shortenUrl()">
                    <div class="form-group">
                        <label for="url">URL</label>
                        <input class="form-control" type="text" name="url" id="url" placeholder="Enter URL" v-model="url"/>
                    </div>
                    <div class="form-group mt-4 d-flex justify-content-end">
                        <button class="btn btn-primary" type="button" :disabled="loading" @click="shortenUrl">
                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" v-if="loading"></span>
                            <span class="sr-only">Shorten</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-4" v-if="shortenedUrl.length > 0">
            <div class="card-header">
                <h4>Shortened URLs:</h4>
            </div>
            <div class="card-body">
                <div class="row mb-2" v-for="url in shortenedUrl">
                    <div class="col-md-6">
                        <a :href="url.url" target="_blank">{{ url.url }}</a>
                    </div>
                    <div class="col-md-4">
                        <a :href="url.shortened_url" target="_blank">{{ url.shortened_url }}</a>
                    </div>
                    <div class="col-md-2 d-flex justify-content-end">
                        <div>
                            <button class="btn btn-warning text-white" @click="copyToClipboard(url.shortened_url)">Copy</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';
    export default {
        data() {
            return {
                url: '',
                loading: false,
                errors: [],
                shortenedUrl:[
                ]
            }
        },
        methods: {
            shortenUrl() {
                if (this.loading) {
                    return;
                }
                console.log(1)
                this.loading = true;
                axios.post('/api/shorten-url', {
                    url: this.url
                }).then(response => {
                    this.shortenedUrl.push(response.data.data.shortened_url);
                    this.url = '';
                    this.errors = [];
                }).catch(error => {
                    console.log(error.response.data);
                    this.errors = error.response.data.errors;
                }).finally(() => {
                    this.loading = false;
                });
            },
            copyToClipboard(text) {
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(text).then(() => {
                        alert('Copied to clipboard');

                    }).catch(err => {
                        console.error('Could not copy text: ', err);
                    });
                } else {
                    console.error('Clipboard API not available');
                }

            }
        }
    }
</script>