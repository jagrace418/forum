<template>
	<div class="alert alert-success alert-flash" role="alert" v-show="show">
		<strong>Success!</strong> {{body}}
	</div>
</template>

<script>
    export default {
        props: ['message'],
        data() {
            return {
                body: '',
                show: false,
            }
        },

        created() {
            if (this.message) {
                this.flash(this.message);
            }

            window.events.$on('flash', message => {
                this.flash(message);
            });
        },

        methods: {
            hide() {
                setTimeout(() => {
                    this.show = false
                }, 3000);
            },

            flash(message) {
                this.body = message;
                this.show = true;
                this.hide();
            }

        }

    }
</script>

<style>
	.alert-flash {
		position: fixed;
		right: 25px;
		bottom: 25px;
	}
</style>