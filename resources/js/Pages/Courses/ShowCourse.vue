<template>
    <Navbar />
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-xl mt-8">
      <img :src="course.photo_url" alt="Course Image" class="rounded-lg w-full h-64 object-cover mb-6" />

      <h1 class="text-2xl font-bold mb-2">{{ course.title }}</h1>
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


    </div>
    <Footer/>
  </template>

  <script setup>
  import Navbar from '@/Components/Navbar.vue';
  import Footer from '@/Components/Footer.vue'
  import { Link } from '@inertiajs/vue3';
  import { route } from 'ziggy-js';
  import { loadStripe } from '@stripe/stripe-js'
    import axios from 'axios'
    import { computed } from 'vue'

  const props = defineProps({
    course: Object,
    authUser : Object,
    isEnrolled: Boolean,
  })

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

  </script>
