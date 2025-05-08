<template>
  <div class="dashboard-container">
    <header>
      <h2>My Tasks</h2>
      <nav>
        <router-link to="/tasks/new">➕ New Task</router-link>
        <a href="#" @click.prevent="logout">🚪 Logout</a>
      </nav>
    </header>

    <div v-if="user">
      <p>Welcome, {{ user.name }}</p>
    </div>
    
    <!-- Task List -->
    <div v-if="tasks.length > 0">
      <div class="dashboard">
        <h1>Task Dashboard</h1>

        <div v-if="loading">Loading tasks...</div>
        <div v-else-if="!tasks.length">No tasks available.</div>

        <ul class="task-list" v-else>
          <li v-for="task in tasks" :key="task.id" class="task-item">
            <div class="task-header">
              <strong>{{ task.title }}</strong>
              <span v-if="task.completed" class="completed">✔️</span>
            </div>
            <p>{{ task.body }}</p>
          </li>
        </ul>
      </div>

      <!-- Pagination -->
      <div class="pagination">
        <button 
          @click="fetchTasks(tasks.prev_page_url)" 
          :disabled="!tasks.prev_page_url">Previous</button>

        <span>Page {{ tasks.current_page }} of {{ tasks.last_page }}</span>

        <button 
          @click="fetchTasks(tasks.next_page_url)" 
          :disabled="!tasks.next_page_url">Next</button>
      </div>
    </div>

    <!-- No tasks message -->
    <div v-else>
      <p>No tasks available!</p>
    </div>
  </div>
</template>

<script>
import axios from '../axios'

export default {
  data() {
    return {
      user: null,
      tasks: [],
      loading: false
    }
  },
  methods: {
    // Fetch the authenticated user details
    async fetchUser() {
      try {
        const response = await axios.get('/api/user')
        this.user = response.data
      } catch (err) {
        console.error('Error fetching user:', err)
      }
    },

    // Fetch tasks with pagination
    async fetchTasks(pageUrl = '/api/tasks') {
      this.loading = true
      try {
        const response = await axios.get(pageUrl)
        this.tasks = response.data
      } catch (err) {
        console.error('Error fetching tasks:', err)
      } finally {
        this.loading = false
      }
    },

    // Logout user and redirect to login page
    async logout() {
      await axios.post('/api/logout')
      localStorage.removeItem('auth_token')
      this.$router.push('/login')
    }
  },
  created() {
    this.fetchUser()
    this.fetchTasks() // Fetch tasks on page load
  }
}
</script>

<style scoped>
.dashboard-container {
  max-width: 800px;
  margin: 50px auto;
  background: #ffe6f0;
  padding: 25px;
  border-radius: 12px;
  box-shadow: 0 0 10px #ffb6c1;
}

header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

header nav a {
  margin-left: 15px;
  font-weight: bold;
}

/* Dashboard container */
.dashboard {
  max-width: 700px;
  margin: 60px auto;
  padding: 30px;
  background: #fff0f5;
  border: 2px solid #ffc0cb;
  border-radius: 16px;
  box-shadow: 0 8px 16px rgba(255, 105, 180, 0.2);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Header */
h1 {
  text-align: center;
  margin-bottom: 24px;
  color: #d63384;
  font-size: 2rem;
}

/* Task list styles */
.task-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.task-item {
  background-color: #ffe6f0;
  border: 1px solid #f8b4cc;
  border-radius: 10px;
  padding: 16px;
  margin-bottom: 12px;
  transition: all 0.3s ease-in-out;
}

.task-item:hover {
  transform: scale(1.01);
  box-shadow: 0 4px 12px rgba(255, 182, 193, 0.3);
}

/* Header inside task */
.task-header {
  display: flex;
  justify-content: space-between;
  font-size: 1.1rem;
  font-weight: bold;
  color: #cc3366;
  margin-bottom: 6px;
}

/* Completed icon */
.completed {
  color: #28a745;
  font-size: 1.2rem;
}

/* Paragraph body text */
.task-item p {
  margin: 0;
  color: #555;
  font-size: 0.95rem;
}

/* Loading and empty text */
.dashboard div[v-if],
.dashboard div[v-else-if] {
  text-align: center;
  padding: 10px;
  color: #888;
}

.button {
  padding: 8px 16px;
  background-color: #ff69b4;
  border: none;
  color: white;
  font-weight: bold;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.3s;
  margin-top: 12px;
}

.button:hover {
  background-color: #e0559c;
}

.pagination {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 20px;
}

.pagination button {
  padding: 8px 15px;
  background-color: #ff69b4;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
}

.pagination button:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}
</style>