<template>
    <div class="min-h-screen bg-background">
        <nav class="border-b bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="relative flex h-16 items-center justify-between">
                    <div class="flex flex-1 items-center gap-6">
                        <Link :href="route('tracks.index')" class="flex items-center gap-2">
                            <img class="h-8 w-auto" src="/images/spotify.png" alt="Logo">
                        </Link>
                        <div class="hidden sm:flex sm:gap-1">
                            <Link
                                :href="route('tracks.index')"
                                class="px-3 py-2 rounded-md text-sm font-medium transition-colors"
                                :class="route().current().includes('tracks') 
                                    ? 'bg-accent text-accent-foreground' 
                                    : 'text-muted-foreground hover:text-foreground hover:bg-accent/50'"
                            >
                                Musiques
                            </Link>
                            <Link
                                :href="route('playlists.index')"
                                class="px-3 py-2 rounded-md text-sm font-medium transition-colors"
                                :class="route().current().includes('playlists') 
                                    ? 'bg-accent text-accent-foreground' 
                                    : 'text-muted-foreground hover:text-foreground hover:bg-accent/50'"
                            >
                                Playlists
                            </Link>
                            <Link
                                v-if="$page.props.auth.user"
                                :href="route('api-keys.index')"
                                class="px-3 py-2 rounded-md text-sm font-medium transition-colors"
                                :class="route().current().includes('api-keys') 
                                    ? 'bg-accent text-accent-foreground' 
                                    : 'text-muted-foreground hover:text-foreground hover:bg-accent/50'"
                            >
                                Clés API
                            </Link>
                            <Link
                                v-if="$page.props.auth.user"
                                :href="route('clients.index')"
                                class="px-3 py-2 rounded-md text-sm font-medium transition-colors"
                                :class="route().current().includes('clients') 
                                    ? 'bg-accent text-accent-foreground' 
                                    : 'text-muted-foreground hover:text-foreground hover:bg-accent/50'"
                            >
                                Comptes Clients
                            </Link>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('logout')"
                            method="post"
                            as="button"
                            preserve-scroll
                            class="text-sm text-muted-foreground hover:text-foreground transition-colors"
                        >
                            Déconnexion
                        </Link>
                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="text-sm text-muted-foreground hover:text-foreground transition-colors"
                            >
                                Connexion
                            </Link>
                            <Link :href="route('register')">
                                <Button variant="outline" size="sm">
                                    Inscription
                                </Button>
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between mb-8">
                <h1 class="text-3xl font-bold tracking-tight">
                    <slot name="title" />
                </h1>
                <div class="flex items-center gap-2">
                    <slot name="actions" />
                </div>
            </div>

            <slot name="content" />
        </div>
    </div>
</template>

<script>
    import { Link } from '@inertiajs/vue3';
    import { Button } from '@/components/ui/button';

    export default {
        name: 'MusicLayout',
        components: {
            Link,
            Button,
        },
    }
</script>
