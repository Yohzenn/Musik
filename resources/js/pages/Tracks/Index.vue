<template>
    <MusicLayout>
        <template #title>
            Liste des musiques
        </template>

        <template #actions>
            <Link
                v-if="$page.props.auth.user?.admin"
                :href="route('tracks.create')"
            >
                <Button>
                    <Plus class="size-4" />
                    Créer une musique
                </Button>
            </Link>
        </template>

        <template #content>
            <div class="space-y-6">
                <div class="max-w-md">
                    <Input
                        id="search"
                        v-model="search"
                        type="search"
                        name="search"
                        placeholder="Rechercher une musique..."
                    />
                </div>

                <div v-if="filteredTracks.length === 0" class="flex flex-col items-center justify-center py-16">
                    <div class="text-center space-y-4">
                        <div class="text-6xl">🎵</div>
                        <h3 class="text-xl font-semibold">Aucune musique trouvée</h3>
                        <p class="text-muted-foreground">
                            {{ search ? 'Essayez une autre recherche' : 'Aucune musique disponible pour le moment' }}
                        </p>
                    </div>
                </div>

                <div v-else class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <Track
                        v-for="track in filteredTracks"
                        :key="track.slug"
                        :track="track"
                        @listen="handleListen"
                    />
                </div>
            </div>
        </template>
    </MusicLayout>
</template>

<script>
    import MusicLayout from '@/layouts/MusicLayout.vue';
    import Track from '@/components/Tracks/Track.vue';
    import { Link } from '@inertiajs/vue3';
    import { Button } from '@/components/ui/button';
    import { Input } from '@/components/ui/input';
    import { Plus } from 'lucide-vue-next';

    export default {
        name: 'Index',
        components: {
            Link,
            MusicLayout,
            Track,
            Button,
            Input,
            Plus,
        },
        props: {
            tracks: Array,
        },
        data() {
            return {
                audio: null,
                currentAudio: null,
                search: '',
            }
        },
        computed: {
            filteredTracks() {
                return this.tracks.filter(track => track.title.toLowerCase().includes(this.search.toLowerCase()));
            },
        },
        methods: {
            changeCurrentAudio(track) {
                this.audio = new Audio('/storage/' + track.audio);
                this.audio.play();
                this.currentAudio = track.slug;
            },
            handleListen(track) {
                if (! this.audio) {
                    this.changeCurrentAudio(track);
                } else if (track.slug !== this.currentAudio) {
                    this.audio.pause();
                    this.changeCurrentAudio(track);
                } else if (this.audio.paused) {
                    this.audio.play();
                } else {
                    this.audio.pause();
                }
            }
        },
    }
</script>
