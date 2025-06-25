<template>
    <div class="min-h-screen flex flex-col">
    <Navbar />
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-xl mt-8">
      <img :src="course.photo_url" alt="Course Image" class="rounded-lg w-full h-64 object-cover mb-6" />

      <h1 class="text-2xl font-bold mb-2">{{ course.title }}</h1>

      <div v-if="averageRating !== null" class="flex items-center text-yellow-500 mb-2">
        <template v-for="i in 5" :key="i">
            <span v-if="i <= Math.floor(averageRating)">★</span>
            <span v-else>☆</span>
        </template>
        <span class="ml-2 text-gray-700 text-sm">({{ averageRating }}/5)</span>
        </div>

      <p class="text-gray-700 mb-4">{{ course.description }}</p>
      <p class="text-lg font-semibold text-blue-600 mb-6">Price: ${{ course.price }}</p>
      <button
        @click="pay"
        class="mt-4 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed"
        :disabled="props.authUser?.id === props.course.teacher_id || props.isEnrolled"
        >
        {{
            props.authUser?.id === props.course.teacher_id
            ? 'You are the teacher'
            : props.isEnrolled
            ? 'Already Enrolled'
            : 'Pay Now'
        }}
        </button>


      <h2 class="text-xl font-bold mb-4">Lessons</h2>

      <ul v-if="canAccessLessons && course.lessons && course.lessons.length > 0" class="list-disc pl-6 space-y-2">
        <li v-for="lesson in course.lessons" :key="lesson.id">
            <Link
            :href="route('lessons.show', [course.id, lesson.id])"
            class="text-blue-600 hover:underline"
                >
            {{ lesson.title }}
            </Link>
            - {{ lesson.content }}
        </li>
      </ul>

      <div v-else class="text-gray-500 text-center mt-6 border rounded-xl p-4 bg-yellow-50">
        <p class="text-lg font-semibold text-yellow-800 mb-2">
            🔒 You must purchase this course to access the lessons.
        </p>
        <button
        @click="pay"
        class="mt-4 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed"
        :disabled="props.authUser?.id === props.course.teacher_id || props.isEnrolled"
        >
        {{
            props.authUser?.id === props.course.teacher_id
            ? 'You are the teacher'
            : props.isEnrolled
            ? 'Already Enrolled'
            : 'Pay Now To Unlock'
        }}
        </button>
    </div>

    <!--  Button to add lessons  -->
    <Link
        v-if="authUser?.role === 'teacher' && authUser.id === course.teacher_id"
        :href="route('lessons.create', course.id)"
        class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Add Lesson
    </Link>

    <!-- Rating -->
    <div v-if="isEnrolled" class="mt-10 bg-gray-50 p-6 rounded-xl shadow-inner">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Leave a Rating</h2>

        <form @submit.prevent="submitRating" class="space-y-6">
            <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
            <select v-model.number="newRating.rating"
                    class="w-24 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option disabled value="">Select</option>
                <option v-for="n in 5" :key="n" :value="n">{{ n }} ★</option>
            </select>
            </div>

            <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Comment</label>
            <textarea v-model="newRating.comment"
                        placeholder="Write something..."
                        class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3"
                        rows="4"></textarea>
            </div>

            <div>
            <button type="submit"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 shadow transition">
                Submit Rating
            </button>
            </div>
        </form>
        </div>


    <div v-if="course.ratings && course.ratings.length" class="mt-10 border-t pt-6">
        <h2 class="text-xl font-semibold mb-4">Student Reviews</h2>
        <div
            v-for="rating in course.ratings"
            :key="rating.id"
            class="mb-4 p-4 bg-gray-100 rounded"
        >
            <p class="text-sm text-gray-700 mb-1">
            <strong>{{ rating.user.first_name || rating.user.name }}</strong> rated
            <span class="text-yellow-500 font-bold">{{ rating.rating }}/5</span>
            </p>
            <p class="text-gray-800 italic">{{ rating.comment }}</p>
        </div>
    </div>
    </div>

    <!-- Floating chat -->
    <Chat
      v-if="canAccessLessons"
      :course-id="course.id"
      :user-id="authUser?.id"
      :user-name="authUser?.first_name || authUser?.name"
    />

    <Footer class="mt-auto" />
</div>
  </template>



  <script setup>
  import Navbar from '@/Components/Navbar.vue';
  import Footer from '@/Components/Footer.vue'
  import Chat from '@/Components/Chat.vue'
  import { Link } from '@inertiajs/vue3';
  import { route } from 'ziggy-js';
  import { loadStripe } from '@stripe/stripe-js'
    import axios from 'axios'
    import { ref, computed } from 'vue'

  const props = defineProps({
    course: Object,
    authUser : Object,
    isEnrolled: Boolean,
    averageRating: Number,
  })
  console.log('Ratings:', props.course.ratings)

  const stripePromise = loadStripe(import.meta.env.VITE_STRIPE_KEY)

  const pay = async () => {

    if (!props.authUser) {
    alertLoginRequired()
    return
  }

  try {
    const { data } = await axios.post(route('courses.checkout', props.course.id))
    const stripe = await stripePromise
    stripe.redirectToCheckout({ sessionId: data.id })
     } catch (error) {
    alert('Payment session could not be created.')
    console.error(error)
    }
}

    const alertLoginRequired = () => {
    const loginUrl = route('login.view')
    const confirmLogin = confirm("⚠️ You must be logged in to purchase this course.\n\nWould you like to go to the login page now?")
    if (confirmLogin) {
        window.location.href = loginUrl
    }
    }

    const queryParams = new URLSearchParams(window.location.search)
    const success = queryParams.get('success') === 'true'

    const canAccessLessons = computed(() => {
    if (!props.authUser) return false
    if (props.authUser.id === props.course.teacher_id) return true
    return props.isEnrolled
    })

    const newRating = ref({
    rating: 5,
    comment: ''
    })

    const submitRating = async () => {
    try {
        await axios.post(`/courses/${props.course.id}/ratings`, newRating.value)
        window.location.reload()
    } catch (err) {
        console.error('Rating submission failed:', err)
    }
    }

  </script>
