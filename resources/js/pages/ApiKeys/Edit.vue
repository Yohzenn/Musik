<template>
    <MusicLayout>
        <template #title>
            Modifier la clé API
        </template>

        <template #actions>
            <Link :href="route('api-keys.index')">
                <Button variant="outline">
                    Retour
                </Button>
            </Link>
        </template>

        <template #content>
            <div class="max-w-3xl mx-auto">
                <Card>
                    <CardHeader>
                        <CardTitle>Modifier {{ apiKey.name }}</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <form @submit.prevent="submit" class="space-y-6">
                            <div class="space-y-2">
                                <Label for="name">Nom de la clé</Label>
                                <Input
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    placeholder="Ex: Application Mobile"
                                    :aria-invalid="!!form.errors.name"
                                    required
                                />
                                <p v-if="form.errors.name" class="text-sm text-destructive">
                                    {{ form.errors.name }}
                                </p>
                            </div>

                            <div class="flex items-center justify-end gap-3 pt-4 border-t">
                                <Button
                                    type="button"
                                    variant="outline"
                                    @click="$inertia.visit(route('api-keys.index'))"
                                    :disabled="form.processing"
                                >
                                    Annuler
                                </Button>
                                <Button
                                    type="submit"
                                    :disabled="form.processing"
                                >
                                    <span v-if="form.processing">Enregistrement...</span>
                                    <span v-else>Enregistrer</span>
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
    import { Link, useForm } from '@inertiajs/vue3';
    import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import { Button } from '@/components/ui/button';

    export default {
        name: 'ApiKeysEdit',
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
        props: {
            apiKey: Object,
        },
        data() {
            return {
                form: useForm({
                    name: this.apiKey.name,
                }),
            };
        },
        methods: {
            submit() {
                this.form.put(route('api-keys.update', { api_key: this.apiKey.slug }));
            },
        },
    }
</script>

