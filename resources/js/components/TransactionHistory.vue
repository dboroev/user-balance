<template>
    <div class="card">
        <div class="card-header">История операций</div>
        <div class="card-body">
            <div class="form-group mb-4">
                <input
                    type="text"
                    class="form-control"
                    v-model="searchQuery"
                    placeholder="Поиск по описанию..."
                >
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th @click="sortBy('created_at')">
                            Дата
                            <span class="sort-icon">
                  {{ sortField === 'created_at' ? (sortDirection === 'asc' ? '↑' : '↓') : '' }}
                </span>
                        </th>
                        <th>Описание</th>
                        <th>Сумма</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="transaction in filteredAndSortedTransactions" :key="transaction.id">
                        <td>{{ formatDate(transaction.created_at) }}</td>
                        <td>{{ transaction.description }}</td>
                        <td :class="transaction.type === 'credit' ? 'text-success' : 'text-danger'">
                            {{ transaction.type === 'credit' ? '+' : '-' }}{{ formatCurrency(transaction.amount) }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            transactions: [],
            searchQuery: '',
            sortField: 'created_at',
            sortDirection: 'desc'
        }
    },
    created() {
        this.fetchTransactions();
    },
    computed: {
        filteredAndSortedTransactions() {
            let filtered = this.transactions;

            if (this.searchQuery) {
                filtered = filtered.filter(transaction =>
                    transaction.description.toLowerCase().includes(this.searchQuery.toLowerCase())
                );
            }

            return filtered.sort((a, b) => {
                let modifier = this.sortDirection === 'desc' ? -1 : 1;
                if (this.sortField === 'created_at') {
                    return modifier * (new Date(a.created_at) - new Date(b.created_at));
                }
                return 0;
            });
        }
    },
    methods: {
        fetchTransactions() {
            this.$http.get('/api/transactions')
                .then(response => {
                    this.transactions = response.data;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        },
        sortBy(field) {
            if (this.sortField === field) {
                this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortField = field;
                this.sortDirection = 'desc';
            }
        },
        formatCurrency(value) {
            return new Intl.NumberFormat('ru-RU', {
                style: 'currency',
                currency: 'RUB'
            }).format(value);
        },
        formatDate(date) {
            return new Date(date).toLocaleDateString('ru-RU');
        }
    }
}
</script>

<style scoped>
.sort-icon {
    margin-left: 5px;
    color: #666;
}
</style>
