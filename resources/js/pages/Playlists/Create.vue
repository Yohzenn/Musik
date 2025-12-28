<template>
    <MusicLayout>
        <template #title>
            Créer une playlist
        </template>

        <template #actions>
            <Link :href="route('playlists.index')">
                <Button variant="outline">
                    Retour
                </Button>
            </Link>
        </template>

        <template #content>
            <PlaylistForm :tracks="tracks" />
        </template>
    </MusicLayout>
</template>

<script>
    import MusicLayout from '@/layouts/MusicLayout.vue';
    import { Link } from '@inertiajs/vue3';
    import PlaylistForm from '@/components/Playlists/PlaylistForm.vue';
    import { Button } from '@/components/ui/button';

    export default {
        name: 'Create',
        components: {
            Link,
            MusicLayout,
            PlaylistForm,
            Button,
        },
        props: {
            tracks: Array,
        },
    }
</script>
