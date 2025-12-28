<template>
    <div
        class="max-w-sm rounded overflow-hidden shadow-lg cursor-pointer flex flex-col h-full"
        @click="handleClick"
    >
      <div class="w-full h-64 overflow-hidden">
        <img class="w-full h-full object-cover" :src="`/storage/${track.image}`">
      </div>
      <div class="px-6 py-4 flex-1 flex flex-col">
        <div class="font-bold text-xl mb-2 line-clamp-2">{{ track.title }}</div>
        <small class="text-gray-700 text-base line-clamp-1">
          {{ track.artist }}
        </small>
        <div class="mt-auto pt-3 grid grid-cols-2 gap-2">
            <Link
                v-if="$page.props.isAdmin"
                :href="route('tracks.edit', { track: track })"
                @click.stop
                class="bg-transparent hover:bg-green-500 text-green-700 font-semibold hover:text-white py-2 px-4 border border-green-500 hover:border-transparent rounded text-center"
            >
            Modifier
            </Link>
            <span
                v-if="$page.props.isAdmin"
                @click.stop="destroy"
                class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded text-center cursor-pointer"
            >
            Supprimer
            </span>
        </div>
      </div>
    </div>
</template>

<script>
    import { Link } from '@inertiajs/vue3';

    export default {
        name: 'Track',
        emits: ['listen'],
        components: {
            Link,
        },
        props: {
            track: Object,
        },
        methods: {
            destroy() {
                this.$inertia.delete(route('tracks.destroy', { track: this.track }), {
                    preserveScroll: true,
                });
            },
            handleClick() {
                this.$emit('listen', this.track);
            }
        }
    }
</script>
