<template>
    <MusicLayout>
        <template #title>
            Mes clés API
        </template>

        <template #actions>
            <Link :href="route('api-keys.create')">
                <Button>
                    <Plus class="size-4" />
                    Créer une clé API
                </Button>
            </Link>
        </template>

        <template #content>
            <div class="space-y-6">
                <div v-if="apiKeys.length === 0" class="flex flex-col items-center justify-center py-16">
                    <div class="text-center space-y-4 max-w-md">
                        <div class="text-6xl">🔑</div>
                        <h3 class="text-xl font-semibold">Aucune clé API</h3>
                        <p class="text-muted-foreground">
                            Créez une clé API pour accéder à vos playlists via l'API REST.
                        </p>
                        <Link :href="route('api-keys.create')">
                            <Button>
                                <Plus class="size-4" />
                                Créer ma première clé API
                            </Button>
                        </Link>
                    </div>
                </div>

                <div v-else class="space-y-4">
                    <Card
                        v-for="apiKey in apiKeys"
                        :key="apiKey.slug"
                        class="group"
                    >
                        <CardHeader>
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <CardTitle>{{ apiKey.name }}</CardTitle>
                                    <p class="text-sm text-muted-foreground mt-1">
                                        Créée le {{ apiKey.created_at }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <Link
                                        :href="route('api-keys.edit', { api_key: apiKey.slug })"
                                        class="opacity-0 group-hover:opacity-100 transition-opacity"
                                    >
                                        <Button variant="outline" size="sm">
                                            <Pencil class="size-4" />
                                            Modifier
                                        </Button>
                                    </Link>
                                    <Link
                                        :href="route('api-keys.destroy', { api_key: apiKey.slug })"
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
                            </div>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <div class="space-y-2">
                                <Label>Clé API</Label>
                                <div class="flex items-center gap-2">
                                    <code class="flex-1 bg-muted px-4 py-2 rounded-md text-sm font-mono text-foreground break-all">
                                        {{ showKey[apiKey.slug] ? apiKey.key : '••••••••••••••••••••••••••••••••' }}
                                    </code>
                                    <Button
                                        variant="outline"
                                        size="icon"
                                        @click="toggleShowKey(apiKey.slug)"
                                        :title="showKey[apiKey.slug] ? 'Masquer' : 'Afficher'"
                                    >
                                        <Eye v-if="!showKey[apiKey.slug]" class="size-4" />
                                        <EyeOff v-else class="size-4" />
                                    </Button>
                                    <Button
                                        variant="outline"
                                        size="icon"
                                        @click="copyToClipboard(apiKey.key)"
                                        title="Copier"
                                    >
                                        <Copy class="size-4" />
                                    </Button>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <Card class="mt-8">
                    <CardHeader>
                        <CardTitle>Utilisation de l'API</CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <p class="text-sm text-muted-foreground">
                            Pour accéder à vos playlists via l'API, utilisez le header <code class="bg-muted px-1.5 py-0.5 rounded text-xs font-mono">x-api-key</code> :
                        </p>
                        <div class="relative">
                            <code class="block bg-muted px-4 py-3 rounded-md text-sm font-mono text-foreground overflow-x-auto">
                                curl -H "x-api-key: VOTRE_CLE" http://localhost:8000/api/playlists
                            </code>
                            <Button
                                variant="ghost"
                                size="icon"
                                class="absolute top-2 right-2"
                                @click="copyExampleCommand"
                                title="Copier la commande"
                            >
                                <Copy class="size-4" />
                            </Button>
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
    import { Label } from '@/components/ui/label';
    import { Plus, Pencil, Trash2, Eye, EyeOff, Copy } from 'lucide-vue-next';

    export default {
        name: 'ApiKeysIndex',
        components: {
            Link,
            MusicLayout,
            Card,
            CardContent,
            CardHeader,
            CardTitle,
            Button,
            Label,
            Plus,
            Pencil,
            Trash2,
            Eye,
            EyeOff,
            Copy,
        },
        props: {
            apiKeys: Array,
        },
        data() {
            return {
                showKey: {},
                copiedKey: null,
            };
        },
        methods: {
            toggleShowKey(slug) {
                this.showKey[slug] = !this.showKey[slug];
            },
            async copyToClipboard(key) {
                try {
                    await navigator.clipboard.writeText(key);
                    this.copiedKey = key;
                    setTimeout(() => {
                        this.copiedKey = null;
                    }, 2000);
                } catch (err) {
                    console.error('Erreur lors de la copie:', err);
                }
            },
            copyExampleCommand() {
                const command = 'curl -H "x-api-key: VOTRE_CLE" http://localhost:8000/api/playlists';
                this.copyToClipboard(command);
            },
        },
    }
</script>

