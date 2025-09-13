<template>
    <div class="min-h-screen flex flex-col">
    <Navbar />

    <header class="bg-white shadow">
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">
          Welcome to Upskillify!
        </h1>
        <p>This is the homepage of your online learning platform.</p>
      </div>
    </header>

    <!-- MAIN CONTENT -->
    <div>
      <main>
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
          <div
            class="relative isolate overflow-hidden bg-gray-900 py-24 sm:py-32"
          >
            <!-- Background image -->
            <img
            :src="vectorImage"
              alt=""
              class="absolute inset-0 -z-10 size-full object-cover object-right md:object-center opacity-30"
            />

            <!-- Gradient -->
            <div
              class="absolute -top-52 left-1/2 -z-10 -translate-x-1/2 transform-gpu blur-3xl"
              aria-hidden="true"
            >
              <div
                class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20"
              />
            </div>

            <!-- CONTENT DIFFERENCES -->
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
              <!-- TEACHER VIEW -->
              <div v-if="authUser?.role === 'teacher'">
                <h2 class="text-5xl font-semibold tracking-tight text-white sm:text-7xl">Welcome, Teacher!</h2>
                <p class="mt-6 text-lg text-gray-300">
                  Manage your courses, upload lessons, and track student progress.
                </p>
                <div class="mt-8">
                    <Link
                    v-if="authUser?.role === 'teacher' && route().has('courses.mine')"
                    :href="route('courses.mine')"
                    class="text-blue-400 underline text-lg"
                    >
                    Go to My Courses →
                    </Link>

                </div>
              </div>

              <!-- STUDENT / GUEST VIEW -->
              <div v-else>
                <h2 class="text-5xl font-semibold tracking-tight text-white sm:text-7xl">Start Learning Today</h2>
                <p class="mt-6 text-lg text-gray-300">
                  Browse available courses and grow your skills. Join now or continue where you left off!
                </p>
                <div class="mt-8">
                  <Link :href="route('courses.list')" class="text-blue-400 underline text-lg">
                    View Courses →
                  </Link>
                </div>
              </div>

              <!-- Stats -->
              <dl class="mt-16 grid grid-cols-1 gap-8 sm:mt-20 sm:grid-cols-2 lg:grid-cols-4">
                <div v-for="stat in stats" :key="stat.name" class="flex flex-col-reverse gap-1">
                  <dt class="text-base/7 text-gray-300">{{ stat.name }}</dt>
                  <dd class="text-4xl font-semibold tracking-tight text-white">{{ stat.value }}</dd>
                </div>
              </dl>
            </div>
          </div>
        </div>
      </main>
    </div>

    <!-- Hero section -->
    <section class="bg-white">
  <div class="mx-auto max-w-7xl px-6 py-24 text-center lg:px-8">
    <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
      Learn at Your Own Pace
    </h1>
    <p class="mt-6 text-lg leading-8 text-gray-600">
      Upskill with high-quality, expert-led courses anytime, anywhere.
    </p>
    <div class="mt-10 flex items-center justify-center gap-x-6">
      <a href="/courses" class="rounded-md bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
        Browse Courses
      </a>
      <a href="/register" class="text-sm font-semibold text-gray-900">Get Started <span aria-hidden="true">→</span></a>
    </div>
  </div>
</section>

<!-- Learners Image Section -->
<section class="bg-white py-20">
  <div class="max-w-7xl mx-auto px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

    <!-- Left: Image -->
    <div>
        <img src="https://smowl.net/wp-content/uploads/2024/07/digital-learners-characteristics.jpg" alt="Learners" class="w-full rounded-lg shadow-md" />

    </div>

    <!-- Right: Text -->
    <div>
      <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">Join a Community of Learners</h2>
      <p class="mt-4 text-lg text-gray-600">
        Upskillify connects passionate students with expert instructors across fields like development,
        design, marketing, and more. Learn with peers, share ideas, and grow together.
      </p>
      <div class="mt-6">
        <a href="/courses" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-md text-sm font-medium shadow hover:bg-indigo-500">
          Explore Courses
        </a>
      </div>
    </div>

  </div>
</section>




<!-- Feature section -->
<section class="bg-gray-50 py-20">
  <div class="max-w-7xl mx-auto px-6 lg:px-8">
    <div class="mb-10 text-center">
      <h2 class="text-base font-semibold text-indigo-600">Why Upskillify?</h2>
      <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Learn smarter, grow faster</p>
    </div>
    <div class="grid grid-cols-1 gap-12 md:grid-cols-3">
      <div class="text-center">
        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100 text-indigo-600">
          📚
        </div>
        <h3 class="mt-4 text-lg font-medium text-gray-900">Expert-led Courses</h3>
        <p class="mt-2 text-sm text-gray-600">Learn from industry professionals with hands-on experience.</p>
      </div>
      <div class="text-center">
        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100 text-indigo-600">
          ⏰
        </div>
        <h3 class="mt-4 text-lg font-medium text-gray-900">Flexible Learning</h3>
        <p class="mt-2 text-sm text-gray-600">Take courses anytime, at your own pace, from any device.</p>
      </div>
      <div class="text-center">
        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100 text-indigo-600">
          🏆
        </div>
        <h3 class="mt-4 text-lg font-medium text-gray-900">Certificates</h3>
        <p class="mt-2 text-sm text-gray-600">Earn recognized certificates to boost your CV and LinkedIn.</p>
      </div>
    </div>
  </div>
</section>

<!-- TEstemonial section  -->
<section class="bg-white py-16">
  <div class="max-w-7xl mx-auto px-6 lg:px-8">
    <div class="text-center">
      <h2 class="text-lg font-semibold text-indigo-600">What Our Learners Say</h2>
      <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900">Success Stories</p>
    </div>
    <div class="mt-10 grid gap-8 md:grid-cols-3">
      <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
        <p class="text-sm text-gray-700">"Upskillify helped me land my first job as a developer. The content was practical and easy to follow."</p>
        <div class="mt-4 text-sm font-semibold text-indigo-600">— Alex, Junior Developer</div>
      </div>
      <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
        <p class="text-sm text-gray-700">"The flexibility allowed me to learn while working full time. Highly recommended!"</p>
        <div class="mt-4 text-sm font-semibold text-indigo-600">— Maria, UX Designer</div>
      </div>
      <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
        <p class="text-sm text-gray-700">"Great teachers and real-world examples. I finally understand Laravel!"</p>
        <div class="mt-4 text-sm font-semibold text-indigo-600">— Ivan, Backend Dev</div>
      </div>
    </div>
  </div>
</section>

<!-- Banner  -->
<section class="bg-indigo-600">
  <div class="max-w-7xl mx-auto py-12 px-6 text-center sm:px-6 lg:px-8">
    <h2 class="text-3xl font-bold text-white sm:text-4xl">
      Ready to start learning?
    </h2>
    <p class="mt-4 text-lg text-indigo-200">Join thousands of learners and build your skills today.</p>
    <div class="mt-6">
      <a href="/register" class="inline-block rounded-md bg-white px-6 py-3 text-sm font-semibold text-indigo-600 hover:bg-indigo-50">
        Get Started
      </a>
    </div>
  </div>
</section>




    <Footer />
</div>
  </template>

  <script setup>
  import { Link } from '@inertiajs/vue3'
  import Navbar from '@/Components/Navbar.vue'
  import Footer from '@/Components/Footer.vue'
  import vectorImage from '@/images/Vector_2646.jpg'
//   import learners from '@/images/learners.png'

  const props = defineProps({
    authUser: Object,
  })

  const stats = [
    { name: 'Students', value: '2,000+' },
    { name: 'Courses Available', value: '150+' },
    { name: 'Teachers', value: '45' },
    { name: 'Hours of Content', value: '800+' },
  ]
  </script>
