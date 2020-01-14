<template>
	<button @click="toggle" class="btn btn-outline-dark" type="submit">
		<i :class="heart"></i>
		<span v-text="favoritesCount"></span>
	</button>
</template>

<script>
    export default {
        name: "Favorite",
        props: ['reply'],
        data() {
            return {
                favoritesCount: this.reply.favoritesCount,
                isFavorited: this.reply.isFavorited,
            }
        },
        computed: {
            heart() {
                return [this.isFavorited ? 'fas fa-heart' : 'far fa-heart'];
            },
            url() {
                return '/replies/' + this.reply.id + '/favorites'
            }
        },
        methods: {
            toggle() {
                return this.isFavorited ? this.destroy() : this.create();
            },

            create() {
                axios.post(this.url());
                this.isFavorited = true;
                this.favoritesCount++;
            },

            destroy() {
                axios.delete(this.url());
                this.isFavorited = false;
                this.favoritesCount--;
            }
        }
    }
</script>

<style scoped>

</style>