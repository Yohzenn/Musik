<template>
    <MusicLayout>
        <template #title>
            Créer une musique
        </template>

        <template #actions>
            <Link :href="route('tracks.index')">
                <Button variant="outline">
                    Retour
                </Button>
            </Link>
        </template>

        <template #content>
            <div class="max-w-3xl mx-auto">
                <Card>
                    <CardHeader>
                        <CardTitle>Nouvelle musique</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <form @submit.prevent="submit" class="space-y-6">
                            <div class="space-y-2">
                                <Label for="title">Titre</Label>
                                <Input
                                    id="title"
                                    v-model="form.title"
                                    type="text"
                                    placeholder="Titre de la musique"
                                    :aria-invalid="!!form.errors.title"
                                />
                                <p v-if="form.errors.title" class="text-sm text-destructive">
                                    {{ form.errors.title }}
                                </p>
                            </div>

                            <div class="space-y-2">
                                <Label for="artist">Artiste</Label>
                                <Input
                                    id="artist"
                                    v-model="form.artist"
                                    type="text"
                                    placeholder="Nom de l'artiste"
                                    :aria-invalid="!!form.errors.artist"
                                />
                                <p v-if="form.errors.artist" class="text-sm text-destructive">
                                    {{ form.errors.artist }}
                                </p>
                            </div>

                            <div class="space-y-2">
                                <Label for="image">Image</Label>
                                <Input
                                    id="image"
                                    type="file"
                                    accept="image/*"
                                    @input="form.image = $event.target.files[0]"
                                    :aria-invalid="!!form.errors.image"
                                />
                                <p v-if="form.errors.image" class="text-sm text-destructive">
                                    {{ form.errors.image }}
                                </p>
                            </div>

                            <div class="space-y-2">
                                <Label for="music">Fichier audio</Label>
                                <Input
                                    id="music"
                                    type="file"
                                    accept="audio/*"
                                    @input="form.music = $event.target.files[0]"
                                    :aria-invalid="!!form.errors.music"
                                />
                                <p v-if="form.errors.music" class="text-sm text-destructive">
                                    {{ form.errors.music }}
                                </p>
                            </div>

                            <div class="flex items-center justify-end gap-3 pt-4 border-t">
                                <Button
                                    type="button"
                                    variant="outline"
                                    @click="$inertia.visit(route('tracks.index'))"
                                    :disabled="form.processing"
                                >
                                    Annuler
                                </Button>
                                <Button
                                    type="submit"
                                    :disabled="form.processing"
                                >
                                    <span v-if="form.processing">Création...</span>
                                    <span v-else>Créer la musique</span>
                                </Button>
                            </div>
                        </form>
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
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import { Button } from '@/components/ui/button';

    export default {
        name: 'Create',
        components: {
            Link,
            MusicLayout,
            Card,
            CardContent,
            CardHeader,
            CardTitle,
            Input,
            Label,
            Button,
        },
        data() {
            return {
                form: this.$inertia.form({
                    title: '',
                    artist: '',
                    image: null,
                    music: null,
                }),
            }
        },
        methods: {
            submit() {
                this.form.post(route('tracks.store'));
            }
        }
    }
</script>
