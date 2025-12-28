<template>
    <div class="max-w-3xl mx-auto">
        <Card>
            <CardHeader>
                <CardTitle>
                    {{ playlist ? 'Modifier la playlist' : 'Créer une nouvelle playlist' }}
                </CardTitle>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="space-y-2">
                        <Label for="title">Titre de la playlist</Label>
                        <Input
                            id="title"
                            v-model="form.title"
                            type="text"
                            placeholder="Ma super playlist..."
                            :aria-invalid="!!form.errors.title"
                        />
                        <p v-if="form.errors.title" class="text-sm text-destructive">
                            {{ form.errors.title }}
                        </p>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <Label>Musiques</Label>
                            <div class="flex items-center gap-2 text-sm text-muted-foreground">
                                <span>{{ selectedTracks.length }} sélectionnée{{ selectedTracks.length > 1 ? 's' : '' }}</span>
                                <button
                                    type="button"
                                    @click="selectAll"
                                    class="text-primary hover:underline"
                                >
                                    Tout sélectionner
                                </button>
                                <span class="text-muted-foreground">|</span>
                                <button
                                    type="button"
                                    @click="deselectAll"
                                    class="text-primary hover:underline"
                                >
                                    Tout désélectionner
                                </button>
                            </div>
                        </div>

                        <div
                            v-if="tracks.length === 0"
                            class="text-center py-8 text-muted-foreground"
                        >
                            Aucune musique disponible
                        </div>

                        <div
                            v-else
                            class="space-y-2 max-h-[500px] overflow-y-auto pr-2"
                        >
                            <div
                                v-for="track in tracks"
                                :key="track.slug"
                                class="flex items-center gap-3 p-3 rounded-lg border hover:bg-accent/50 transition-colors cursor-pointer"
                                @click="toggleTrack(track.slug)"
                            >
                                <input
                                    type="checkbox"
                                    :id="'tracks_' + track.slug"
                                    :checked="selectedTracks.includes(track.slug)"
                                    @click.stop="toggleTrack(track.slug)"
                                    class="size-4 shrink-0 rounded border border-input accent-primary cursor-pointer"
                                />
                                <div class="flex-1 cursor-pointer">
                                    <div class="font-medium">{{ track.title }}</div>
                                    <div class="text-sm text-muted-foreground">{{ track.artist }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t">
                        <Button
                            type="button"
                            variant="outline"
                            @click="$inertia.visit(route('playlists.index'))"
                            :disabled="form.processing"
                        >
                            Annuler
                        </Button>
                        <Button
                            type="submit"
                            :disabled="form.processing"
                        >
                            <span v-if="form.processing">Enregistrement...</span>
                            <span v-else>{{ playlist ? 'Modifier' : 'Créer' }}</span>
                        </Button>
                    </div>
                </form>
            </CardContent>
        </Card>
    </div>
</template>

<script>
    import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import { Checkbox } from '@/components/ui/checkbox';
    import { Button } from '@/components/ui/button';

    export default {
        name: 'PlaylistForm',
        components: {
            Card,
            CardContent,
            CardHeader,
            CardTitle,
            Input,
            Label,
            Checkbox,
            Button,
        },
        props: {
            playlist: Object,
            tracks: Array,
        },
        data() {
            const initialTracks = this.playlist?.tracks?.map(track => track.slug) ?? [];
            return {
                selectedTracks: [...initialTracks], // Propriété réactive séparée
                form: this.$inertia.form({
                    title: this.playlist?.title ?? '',
                    tracks: [...initialTracks],
                }),
            }
        },
        watch: {
            // Synchroniser selectedTracks avec form.tracks avant la soumission
            selectedTracks: {
                handler(newTracks) {
                    this.form.tracks = [...newTracks];
                },
                deep: true,
                immediate: true,
            },
        },
        methods: {
            submit() {
                // S'assurer que form.tracks est à jour avant la soumission
                this.form.tracks = [...this.selectedTracks];
                if (this.playlist) {
                    this.form.put(route('playlists.update', { playlist: this.playlist }));
                } else {
                    this.form.post(route('playlists.store'));
                }
            },
            toggleTrack(slug) {
                const index = this.selectedTracks.indexOf(slug);
                if (index > -1) {
                    this.selectedTracks.splice(index, 1);
                } else {
                    this.selectedTracks.push(slug);
                }
            },
            handleCheckboxChange(slug, checked) {
                if (checked) {
                    if (!this.selectedTracks.includes(slug)) {
                        this.selectedTracks.push(slug);
                    }
                } else {
                    const index = this.selectedTracks.indexOf(slug);
                    if (index > -1) {
                        this.selectedTracks.splice(index, 1);
                    }
                }
            },
            selectAll() {
                this.selectedTracks = [...this.tracks.map(track => track.slug)];
            },
            deselectAll() {
                this.selectedTracks = [];
            },
        }
    }
</script>
