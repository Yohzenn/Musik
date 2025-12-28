<template>
    <MusicLayout>
        <template #title>
            Mes playlists
        </template>

        <template #actions>
            <Link :href="route('playlists.create')">
                <Button>
                    <Plus class="size-4" />
                    Créer une playlist
                </Button>
            </Link>
        </template>

        <template #content>
            <div v-if="playlists.length === 0" class="flex flex-col items-center justify-center py-16">
                <div class="text-center space-y-4 max-w-md">
                    <div class="text-6xl">🎵</div>
                    <h3 class="text-xl font-semibold">Aucune playlist</h3>
                    <p class="text-muted-foreground">
                        Créez votre première playlist pour organiser vos musiques préférées.
                    </p>
                    <Link :href="route('playlists.create')">
                        <Button>
                            <Plus class="size-4" />
                            Créer ma première playlist
                        </Button>
                    </Link>
                </div>
            </div>

            <div v-else class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                <Card
                    v-for="playlist in playlists"
                    :key="playlist.slug"
                    class="group hover:shadow-md transition-shadow"
                >
                    <CardHeader>
                        <div class="flex items-start justify-between">
                            <div class="flex-1 min-w-0">
                                <CardTitle class="line-clamp-2">{{ playlist.title }}</CardTitle>
                                <p class="text-sm text-muted-foreground mt-1">
                                    {{ playlist.tracks_count }} {{ playlist.tracks_count === 1 ? 'musique' : 'musiques' }}
                                </p>
                            </div>
                        </div>
                    </CardHeader>
                    <CardContent>
                        <div class="flex items-center justify-end gap-2">
                            <Link
                                :href="route('playlists.edit', { playlist: playlist })"
                                class="opacity-0 group-hover:opacity-100 transition-opacity"
                            >
                                <Button variant="outline" size="sm">
                                    <Pencil class="size-4" />
                                    Modifier
                                </Button>
                            </Link>
                            <Link
                                :href="route('playlists.destroy', { playlist: playlist })"
                                method="delete"
                                as="button"
                                class="opacity-0 group-hover:opacity-100 transition-opacity"
                            >
                                <Button variant="destructive" size="sm">
                                    <Trash2 class="size-4" />
                                    Supprimer
                                </Button>
                            </Link>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </template>
    </MusicLayout>
</template>

<script>
    import MusicLayout from '@/layouts/MusicLayout.vue';
    import { Link } from '@inertiajs/vue3';
    import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
    import { Button } from '@/components/ui/button';
    import { Plus, Pencil, Trash2 } from 'lucide-vue-next';

    export default {
        name: 'Index',
        components: {
            Link,
            MusicLayout,
            Card,
            CardContent,
            CardHeader,
            CardTitle,
            Button,
            Plus,
            Pencil,
            Trash2,
        },
        props: {
            playlists: Array,
        },
    }
</script>
