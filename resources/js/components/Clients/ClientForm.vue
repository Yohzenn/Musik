<template>
    <div class="max-w-3xl mx-auto">
        <Card>
            <CardHeader>
                <CardTitle>
                    {{ client ? 'Modifier le client' : 'Créer un nouveau client' }}
                </CardTitle>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="submit" novalidate class="space-y-6">
                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="space-y-2">
                            <Label for="email">Email <span class="text-destructive">*</span></Label>
                            <Input
                                id="email"
                                v-model="form.email"
                                type="email"
                                placeholder="client@example.com"
                                required
                                :class="{ 'border-destructive': form.errors.email }"
                                :aria-invalid="!!form.errors.email"
                            />
                            <p v-if="form.errors.email" class="text-sm text-destructive">
                                {{ form.errors.email }}
                            </p>
                        </div>

                        <div class="space-y-2">
                            <Label for="civility">Civilité <span class="text-destructive">*</span></Label>
                            <select
                                id="civility"
                                v-model="form.civility"
                                required
                                class="flex h-9 w-full rounded-md border bg-transparent px-3 py-1 text-base shadow-xs transition-colors focus-visible:outline-none focus-visible:ring-[3px] focus-visible:ring-ring/50 focus-visible:border-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
                                :class="form.errors.civility ? 'border-destructive' : 'border-input'"
                                :aria-invalid="!!form.errors.civility"
                            >
                                <option value="" disabled>Sélectionnez une civilité</option>
                                <option value="Monsieur">Monsieur</option>
                                <option value="Madame">Madame</option>
                            </select>
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
                                :class="{ 'border-destructive': form.errors.company }"
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
                                :class="{ 'border-destructive': form.errors.last_name }"
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
                                :class="{ 'border-destructive': form.errors.first_name }"
                                :aria-invalid="!!form.errors.first_name"
                            />
                            <p v-if="form.errors.first_name" class="text-sm text-destructive">
                                {{ form.errors.first_name }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <Label for="address">Adresse postale <span class="text-destructive">*</span></Label>
                        <textarea
                            id="address"
                            v-model="form.address"
                            rows="3"
                            required
                            class="flex min-h-[60px] w-full rounded-md border bg-transparent px-3 py-2 text-base shadow-xs placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-[3px] focus-visible:ring-ring/50 focus-visible:border-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
                            :class="form.errors.address ? 'border-destructive' : 'border-input'"
                            placeholder="Numéro et nom de rue"
                            :aria-invalid="!!form.errors.address"
                        ></textarea>
                        <p v-if="form.errors.address" class="text-sm text-destructive">
                            {{ form.errors.address }}
                        </p>
                    </div>

                    <div class="grid gap-6 md:grid-cols-3">
                        <div class="space-y-2">
                            <Label for="postal_code">Code Postal <span class="text-destructive">*</span></Label>
                            <div class="relative">
                                <Input
                                    id="postal_code"
                                    v-model="form.postal_code"
                                    type="text"
                                    placeholder="75001"
                                    maxlength="5"
                                    minlength="5"
                                    pattern="\d{5}"
                                    required
                                    :class="{ 'border-destructive': form.errors.postal_code }"
                                    :aria-invalid="!!form.errors.postal_code"
                                    @input="onPostalCodeInput"
                                />
                                <div v-if="isLoadingCities" class="absolute right-3 top-1/2 -translate-y-1/2">
                                    <Spinner class="h-4 w-4" />
                                </div>
                            </div>
                            <p v-if="form.errors.postal_code" class="text-sm text-destructive">
                                {{ form.errors.postal_code }}
                            </p>
                            <p v-if="postalCodeError" class="text-sm text-destructive">
                                {{ postalCodeError }}
                            </p>
                        </div>

                        <div class="space-y-2">
                            <Label for="city">Ville <span class="text-destructive">*</span></Label>
                            <!-- Dropdown si plusieurs villes disponibles -->
                            <select
                                v-if="availableCities.length > 1"
                                id="city"
                                v-model="form.city"
                                required
                                class="flex h-9 w-full rounded-md border bg-transparent px-3 py-1 text-base shadow-xs transition-colors focus-visible:outline-none focus-visible:ring-[3px] focus-visible:ring-ring/50 focus-visible:border-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
                                :class="form.errors.city ? 'border-destructive' : 'border-input'"
                                :aria-invalid="!!form.errors.city"
                            >
                                <option value="" disabled>Sélectionnez une ville</option>
                                <option
                                    v-for="city in availableCities"
                                    :key="city"
                                    :value="city"
                                >
                                    {{ city }}
                                </option>
                            </select>
                            <!-- Input standard sinon -->
                            <Input
                                v-else
                                id="city"
                                v-model="form.city"
                                type="text"
                                placeholder="Paris"
                                required
                                :class="{ 'border-destructive': form.errors.city }"
                                :aria-invalid="!!form.errors.city"
                            />
                            <p v-if="form.errors.city" class="text-sm text-destructive">
                                {{ form.errors.city }}
                            </p>
                            <p v-if="availableCities.length > 1" class="text-xs text-muted-foreground">
                                {{ availableCities.length }} villes correspondent à ce code postal
                            </p>
                        </div>

                        <div class="space-y-2">
                            <Label for="country">Pays <span class="text-destructive">*</span></Label>
                            <Input
                                id="country"
                                v-model="form.country"
                                type="text"
                                placeholder="France"
                                required
                                :class="{ 'border-destructive': form.errors.country }"
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
import { Spinner } from '@/components/ui/spinner';
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
        Spinner,
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
                country: this.client?.country ?? 'France',
            }),
            // États pour la recherche de ville via l'API Géoplateforme
            isLoadingCities: false,
            availableCities: [],
            postalCodeError: '',
            searchTimeout: null,
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

        /**
         * Gère l'input du code postal
         * Lance une recherche vers l'API Géoplateforme si le code fait 5 chiffres
         */
        onPostalCodeInput() {
            // Reset des erreurs et villes
            this.postalCodeError = '';
            this.availableCities = [];

            const postalCode = this.form.postal_code.trim();

            // Vérifier que c'est un code postal valide (5 chiffres)
            if (!/^\d{5}$/.test(postalCode)) {
                return;
            }

            // Debounce pour éviter trop de requêtes
            if (this.searchTimeout) {
                clearTimeout(this.searchTimeout);
            }

            this.searchTimeout = setTimeout(() => {
                this.fetchCitiesFromPostalCode(postalCode);
            }, 300);
        },

        /**
         * Interroge l'API Géoplateforme pour récupérer les villes associées à un code postal
         * @param {string} postalCode - Le code postal à rechercher
         */
        async fetchCitiesFromPostalCode(postalCode) {
            this.isLoadingCities = true;
            this.postalCodeError = '';

            try {
                const response = await fetch(
                    `https://data.geopf.fr/geocodage/search?q=${encodeURIComponent(postalCode)}`
                );

                if (!response.ok) {
                    throw new Error('Erreur lors de la recherche');
                }

                const data = await response.json();

                // Filtrer uniquement les résultats de type "municipality" (commune)
                const municipalities = data.features.filter(
                    (feature) => feature.properties.type === 'municipality'
                );

                if (municipalities.length === 0) {
                    this.postalCodeError = 'Aucune ville trouvée pour ce code postal';
                    this.form.city = '';
                    return;
                }

                // Extraire les noms de villes uniques
                const cityNames = [...new Set(
                    municipalities.map((m) => m.properties.city || m.properties.name)
                )];

                this.availableCities = cityNames;

                // Si une seule ville, la sélectionner automatiquement
                if (cityNames.length === 1) {
                    this.form.city = cityNames[0];
                } else {
                    // Plusieurs villes : on réinitialise le champ pour forcer la sélection
                    this.form.city = '';
                }
            } catch (error) {
                console.error('Erreur API Géoplateforme:', error);
                this.postalCodeError = 'Impossible de récupérer les villes. Veuillez saisir manuellement.';
            } finally {
                this.isLoadingCities = false;
            }
        },
    },
};
</script>

