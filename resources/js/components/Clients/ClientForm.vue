<template>
    <div class="max-w-3xl mx-auto">
        <Card>
            <CardHeader>
                <CardTitle>
                    {{ client ? 'Modifier le client' : 'Créer un nouveau client' }}
                </CardTitle>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="space-y-2">
                            <Label for="email">Email <span class="text-destructive">*</span></Label>
                            <Input
                                id="email"
                                v-model="form.email"
                                type="email"
                                placeholder="client@example.com"
                                required
                                :aria-invalid="!!form.errors.email"
                            />
                            <p v-if="form.errors.email" class="text-sm text-destructive">
                                {{ form.errors.email }}
                            </p>
                        </div>

                        <div class="space-y-2">
                            <Label for="civility">Civilité</Label>
                            <Input
                                id="civility"
                                v-model="form.civility"
                                type="text"
                                placeholder="M., Mme, Mlle"
                                :aria-invalid="!!form.errors.civility"
                            />
                            <p v-if="form.errors.civility" class="text-sm text-destructive">
                                {{ form.errors.civility }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <Label for="company">Société</Label>
                        <Input
                            id="company"
                            v-model="form.company"
                            type="text"
                            placeholder="Nom de la société"
                            :aria-invalid="!!form.errors.company"
                        />
                        <p v-if="form.errors.company" class="text-sm text-destructive">
                            {{ form.errors.company }}
                        </p>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="space-y-2">
                            <Label for="last_name">Nom <span class="text-destructive">*</span></Label>
                            <Input
                                id="last_name"
                                v-model="form.last_name"
                                type="text"
                                placeholder="Nom"
                                required
                                :aria-invalid="!!form.errors.last_name"
                            />
                            <p v-if="form.errors.last_name" class="text-sm text-destructive">
                                {{ form.errors.last_name }}
                            </p>
                        </div>

                        <div class="space-y-2">
                            <Label for="first_name">Prénom <span class="text-destructive">*</span></Label>
                            <Input
                                id="first_name"
                                v-model="form.first_name"
                                type="text"
                                placeholder="Prénom"
                                required
                                :aria-invalid="!!form.errors.first_name"
                            />
                            <p v-if="form.errors.first_name" class="text-sm text-destructive">
                                {{ form.errors.first_name }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <Label for="address">Adresse postale</Label>
                        <textarea
                            id="address"
                            v-model="form.address"
                            rows="3"
                            class="flex min-h-[60px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-base shadow-xs placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-[3px] focus-visible:ring-ring/50 focus-visible:border-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
                            placeholder="Numéro et nom de rue"
                            :aria-invalid="!!form.errors.address"
                        ></textarea>
                        <p v-if="form.errors.address" class="text-sm text-destructive">
                            {{ form.errors.address }}
                        </p>
                    </div>

                    <div class="grid gap-6 md:grid-cols-3">
                        <div class="space-y-2">
                            <Label for="postal_code">Code Postal</Label>
                            <Input
                                id="postal_code"
                                v-model="form.postal_code"
                                type="text"
                                placeholder="75001"
                                :aria-invalid="!!form.errors.postal_code"
                            />
                            <p v-if="form.errors.postal_code" class="text-sm text-destructive">
                                {{ form.errors.postal_code }}
                            </p>
                        </div>

                        <div class="space-y-2">
                            <Label for="city">Ville</Label>
                            <Input
                                id="city"
                                v-model="form.city"
                                type="text"
                                placeholder="Paris"
                                :aria-invalid="!!form.errors.city"
                            />
                            <p v-if="form.errors.city" class="text-sm text-destructive">
                                {{ form.errors.city }}
                            </p>
                        </div>

                        <div class="space-y-2">
                            <Label for="country">Pays</Label>
                            <Input
                                id="country"
                                v-model="form.country"
                                type="text"
                                placeholder="France"
                                :aria-invalid="!!form.errors.country"
                            />
                            <p v-if="form.errors.country" class="text-sm text-destructive">
                                {{ form.errors.country }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t">
                        <Button
                            type="button"
                            variant="outline"
                            @click="$inertia.visit(clientsIndex().url)"
                            :disabled="form.processing"
                        >
                            Annuler
                        </Button>
                        <Button
                            type="submit"
                            :disabled="form.processing"
                        >
                            <span v-if="form.processing">Enregistrement...</span>
                            <span v-else>{{ client ? 'Modifier' : 'Créer' }}</span>
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
import { Button } from '@/components/ui/button';
import { index as clientsIndex, store as clientsStore, update as clientsUpdate } from '@/routes/clients';

export default {
    name: 'ClientForm',
    components: {
        Card,
        CardContent,
        CardHeader,
        CardTitle,
        Input,
        Label,
        Button,
    },
    props: {
        client: {
            type: Object,
            default: null,
        },
    },
    data() {
        return {
            clientsIndex,
            clientsStore,
            clientsUpdate,
            form: this.$inertia.form({
                email: this.client?.email ?? '',
                civility: this.client?.civility ?? '',
                company: this.client?.company ?? '',
                last_name: this.client?.last_name ?? '',
                first_name: this.client?.first_name ?? '',
                address: this.client?.address ?? '',
                postal_code: this.client?.postal_code ?? '',
                city: this.client?.city ?? '',
                country: this.client?.country ?? '',
            }),
        };
    },
    methods: {
        submit() {
            if (this.client) {
                this.form.put(clientsUpdate({ client: this.client.id }).url);
            } else {
                this.form.post(clientsStore().url);
            }
        },
    },
};
</script>

