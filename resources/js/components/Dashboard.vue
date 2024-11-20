<template>
    <div class="card">
        <div class="card-header">Баланс пользователя</div>
        <div class="card-body">
            <div class="balance-display mb-4">
                Текущий баланс: {{ formatCurrency(balance) }}
            </div>

            <h5>Последние операции</h5>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Описание</th>
                        <th>Сумма</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="transaction in recentTransactions" :key="transaction.id">
                        <td>{{ formatDate(transaction.created_at) }}</td>
                        <td>{{ transaction.description }}</td>
                        <td :class="transaction.type === 'deposit' ? 'text-success' : 'text-danger'">
                            {{ transaction.type === 'deposit' ? '+' : '-' }}{{ formatCurrency(transaction.amount) }}
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
            balance: 0,
            recentTransactions: [],
            updateInterval: null
        }
    },
    mounted() {
        this.fetchData();
        // T seconds update interval (5 seconds in this example)
        this.updateInterval = setInterval(this.fetchData, 5000);
    },
    beforeDestroy() {
        clearInterval(this.updateInterval);
    },
    methods: {
        fetchData() {
            this.$http.get('/api/dashboard')
                .then(response => {
                    this.balance = response.data.balance;
                    this.recentTransactions = response.data.recent_transactions;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
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
