<template>
    <v-app>
        <v-app-bar app color="blue lighten" class="white--text">
            Laravel & Vue Comment Widget
        </v-app-bar>
        <v-content>
            <v-container fluid>
                <v-row>
                    <v-col 
                        cols="6" 
                        offset="3"
                    >
                        <v-card
                            :loading="loading"
                            tile
                        >   
                            <v-card-title>
                                Comments
                            </v-card-title>
                            <v-card-text v-if="comments.length > 0">
                                <v-card
                                    v-for="(comment, index) in comments"
                                    :key="index"
                                    tile
                                    class="pa-0 ma-0"
                                >
                                    <v-card-title>
                                        {{ comment.name }}
                                    </v-card-title>
                                    <v-card-subtitle>
                                        {{ comment.email }}
                                    </v-card-subtitle>
                                    <v-card-text>
                                        {{ comment.comment }}
                                    </v-card-text>
                                </v-card>
                            </v-card-text>
                            <v-card-text v-else-if="!loading">
                                No comments yet.
                            </v-card-text>
                            <v-card-text>
                                <v-card>
                                    <v-card-title>
                                        Submit a new comment
                                    </v-card-title>
                                    <v-card-text>
                                        <v-form 
                                            ref="form"
                                            v-model="valid"
                                            @submit.prevent="postComment"
                                        >
                                        <v-text-field
                                            v-model="formData.name"
                                            label="Name"
                                            required
                                            :rules="rules['name']"
                                        />
                                        <v-text-field
                                            v-model="formData.email"
                                            label="Email"
                                            required
                                            :rules="rules['email']"
                                        />
                                        <v-textarea
                                            v-model="formData.comment"
                                            label="Comment"
                                            required
                                            :rules="rules['comment']"
                                        />
                                        <v-btn
                                            :disabled="!valid"
                                            tile
                                            raised
                                            type="submit"
                                        >
                                            Submit Comment
                                        </v-btn>
                                    </v-form>
                                    </v-card-text>
                                </v-card>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
        <v-footer color="blue lighten" class="white--text">
            &copy; Jared Martinez 2020
            <v-snackbar 
                v-model="showMessage"
                :timeout="1000"
                right
            >
                {{ snackbarText }}
            </v-snackbar>
        </v-footer>
    </v-app>
</template>

<script>

export default {
    name: 'App',
    data() {
        return {
            loading: false,
            showMessage: false,
            snackbarText: '',
            valid: false,
            rules: {
                name: [v => !!v || 'Please enter your name'],
                email: [
                    v => !!v || 'Please enter your email',
                    v => (/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/).test(v) || 'Please enter a valid email'
                ],
                comment: [v => !!v || 'Please enter a comment'],
            },
            formData: {
                name: '',
                email: '',
                comment: '',
            },
            comments: [],
            interval: null,
        };
    },
    mounted() {
        // Populate comments
        this.getLastFiveComments();

        // Refresh feed every 30 seconds
        this.interval = setInterval(this.getLastFiveComments, 30000);
    },
    methods: {
        async getLastFiveComments() {
            this.loading = true;
            try {
                // Grab the comments
                const { data, status } = await this.$http('/comments');
                if(status === 200) {
                    this.comments = data;
                    return;
                }
                throw new Error(status);
            } catch(e) {
                this.snackbarText = 'Could not load comments at this time.'
                this.showMessage = true;
            } finally {
                // It runs so fast I have to artificially make it slower
                // for the loading bar to have any UX value lol
                setTimeout(() => {
                    this.loading = false;
                }, 500);
            }
        },
        async postComment() {
            try {

                const { status } = await this.$http.post('/comments/create', this.formData);
                if(status === 204) {
                    // Push the comment into the page
                    this.comments.unshift({ ...this.formData });
                    if(this.comments.length > 5) this.comments.pop();
                    
                    // Show success message
                    this.snackbarText = 'Comment saved.';

                    // Clear form
                    this.$refs.form.reset();
                    return;
                }
                throw new Error(status);
            } catch(e) {
                this.snackbarText = 'Could not save comment at this time.'
            } finally {
                this.showMessage = true;
            }
        }
    }
}
</script>
