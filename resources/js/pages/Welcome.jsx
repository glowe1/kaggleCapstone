import React from 'react';
import { useNavigate } from 'react-router-dom';
import {
  Users, Calendar, Activity, Heart, Pill, Moon, ClipboardList,
  AlertCircle, Building2, Stethoscope, BarChart3, Shield, Clock,
  CheckCircle, FileText, TrendingUp, Zap, Database, Settings,
  Mail, Lock, Bell, Server, UserCheck, MapPin, ShoppingCart,
  DollarSign, Bed, ArrowRight
} from 'lucide-react';
import PublicNavigation from '../components/PublicNavigation';
import PublicFooter from '../components/PublicFooter';

export default function Welcome() {
  const navigate = useNavigate();

  const features = [
    {
      icon: Users,
      title: 'Resident Management',
      description: 'Comprehensive resident profiles with medical history, care plans, and family contacts.',
      color: 'from-blue-500 to-cyan-500'
    },
    {
      icon: Pill,
      title: 'Medication Management',
      description: 'Track medication administration, schedules, and compliance with automated reminders.',
      color: 'from-blue-600 to-blue-500'
    },
    {
      icon: Heart,
      title: 'Vital Signs Monitoring',
      description: 'Record and track vital signs with customizable ranges and alert thresholds.',
      color: 'from-cyan-500 to-cyan-400'
    },
    {
      icon: Calendar,
      title: 'Appointment Scheduling',
      description: 'Schedule and manage healthcare provider appointments with automated reminders.',
      color: 'from-blue-500 to-cyan-500'
    },
    {
      icon: ClipboardList,
      title: 'Assessments',
      description: 'Conduct comprehensive resident assessments with customizable forms and templates.',
      color: 'from-blue-600 to-cyan-500'
    },
    {
      icon: Moon,
      title: 'Sleep Monitoring',
      description: 'Track sleep patterns and quality with detailed analytics and reports.',
      color: 'from-cyan-600 to-blue-500'
    },
    {
      icon: UserCheck,
      title: 'Check-In/Check-Out System',
      description: 'Track staff clock-ins, resident sign-outs, and visitor management with real-time monitoring.',
      color: 'from-cyan-500 to-blue-500'
    },
    {
      icon: Building2,
      title: 'Housekeeping',
      description: 'Manage cleaning schedules, tasks, and assignments with quality assurance tracking.',
      color: 'from-blue-500 to-cyan-500'
    },
    {
      icon: AlertCircle,
      title: 'Incident Reporting',
      description: 'Document and track incidents with detailed reporting and follow-up workflows.',
      color: 'from-blue-600 to-cyan-500'
    },
    {
      icon: BarChart3,
      title: 'Analytics & Reports',
      description: 'Generate comprehensive reports and analytics for compliance and decision-making.',
      color: 'from-cyan-500 to-blue-500'
    },
    {
      icon: ShoppingCart,
      title: 'Pharmacy Management',
      description: 'Manage medication inventory, orders, suppliers, and deliveries.',
      color: 'from-blue-500 to-cyan-500'
    },
    {
      icon: DollarSign,
      title: 'Billing & Expenses',
      description: 'Track expenses, generate invoices, and manage financial records.',
      color: 'from-cyan-600 to-blue-500'
    },
  ];

  const modules = [
    { name: 'Residents', icon: Users },
    { name: 'Medications', icon: Pill },
    { name: 'Vitals', icon: Heart },
    { name: 'Appointments', icon: Calendar },
    { name: 'Assessments', icon: ClipboardList },
    { name: 'Sleep Records', icon: Moon },
    { name: 'Housekeeping', icon: Building2 },
    { name: 'Reports', icon: BarChart3 },
    { name: 'Behaviors', icon: Activity },
    { name: 'Incidents', icon: AlertCircle },
    { name: 'Leave Requests', icon: Calendar },
    { name: 'Employee Documents', icon: FileText },
    { name: 'Grocery Status', icon: ShoppingCart },
    { name: 'Fire Drills', icon: AlertCircle },
    { name: 'Billing & Expenses', icon: DollarSign },
  ];

  const benefits = [
    {
      icon: Shield,
      title: 'HIPAA Compliant',
      description: 'Fully compliant with healthcare data protection regulations'
    },
    {
      icon: Zap,
      title: 'Real-Time Updates',
      description: 'Instant notifications and real-time data synchronization'
    },
    {
      icon: Database,
      title: 'Secure Cloud Storage',
      description: 'Your data is safely stored with automated backups'
    },
    {
      icon: Settings,
      title: 'Customizable',
      description: 'Tailor the system to match your facility\'s workflow'
    },
  ];

  return (
    <div className="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-50">
      {/* Navigation */}
      <PublicNavigation />

      {/* Hero Section */}
      <section className="relative overflow-hidden min-h-screen sm:h-screen flex items-center bg-gradient-to-br from-blue-600 via-blue-500 to-cyan-500 py-20 sm:py-0">
        {/* Sophisticated Background Elements */}
        <div className="absolute inset-0 overflow-hidden">
          {/* Animated Gradient Orbs */}
          <div className="absolute top-0 left-1/4 w-[500px] h-[500px] bg-cyan-400/30 rounded-full mix-blend-overlay filter blur-[100px] animate-blob"></div>
          <div className="absolute bottom-0 right-1/4 w-[500px] h-[500px] bg-blue-400/30 rounded-full mix-blend-overlay filter blur-[100px] animate-blob animation-delay-2000"></div>
          <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-white/5 rounded-full mix-blend-overlay filter blur-[120px] animate-blob animation-delay-4000"></div>
          
          {/* Geometric Patterns */}
          <div className="absolute inset-0 opacity-10">
            <div className="absolute top-20 left-20 w-32 h-32 border-2 border-white/30 rotate-45"></div>
            <div className="absolute bottom-20 right-20 w-24 h-24 border-2 border-white/30 rotate-45"></div>
            <div className="absolute top-1/2 right-10 w-16 h-16 border-2 border-white/20 rotate-45"></div>
          </div>
          
          {/* Grid Pattern */}
          <div className="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:50px_50px]"></div>
        </div>

        <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full z-10">
          <div className="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            {/* Left Column - Content */}
            <div className="text-center lg:text-left space-y-5">
              {/* Main Heading */}
              <h1 className="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-black text-white leading-[1.1]">
                <span className="block">Comprehensive</span>
                <span className="block bg-gradient-to-r from-cyan-200 via-white to-cyan-200 bg-clip-text text-transparent">
                  Care Facility
              </span>
                <span className="block text-white">Management</span>
            </h1>

              {/* Subheading */}
              <p className="text-lg sm:text-xl text-white/90 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                Streamline operations, improve care quality, and ensure compliance with our all-in-one platform designed for assisted living facilities.
            </p>

              {/* CTA Buttons */}
              <div className="flex flex-col sm:flex-row gap-3 justify-center lg:justify-start pt-2">
              <button
                  onClick={() => navigate('/register-facility')}
                  className="group relative bg-white text-blue-600 px-6 py-3 rounded-xl font-bold text-base hover:bg-gray-50 transition-all shadow-2xl hover:shadow-cyan-500/50 hover:scale-105 flex items-center justify-center space-x-2 overflow-hidden"
              >
                  <span className="relative z-10">Start Free Trial</span>
                  <ArrowRight className="w-4 h-4 group-hover:translate-x-1 transition-transform relative z-10" />
                  <div className="absolute inset-0 bg-gradient-to-r from-blue-500 to-cyan-500 opacity-0 group-hover:opacity-10 transition-opacity"></div>
              </button>
              <button
                  onClick={() => navigate('/login')}
                  className="bg-white/10 backdrop-blur-md border-2 border-white/30 text-white px-6 py-3 rounded-xl font-bold text-base hover:bg-white/20 transition-all shadow-xl"
              >
                  Sign In
              </button>
              </div>

            </div>

            {/* Right Column - Hero Image */}
            <div className="hidden lg:flex items-center justify-center">
              <div className="relative w-full max-w-lg">
                <div className="absolute -inset-4 bg-white/10 rounded-3xl blur-xl"></div>
                <img
                  src="/images/slides/slide-3-hero.png"
                  alt="HomeLogic360 Dashboard on laptop and tablet"
                  className="relative w-full rounded-2xl shadow-2xl border border-white/20"
                  draggable={false}
                />
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Problem Statement Section */}
      <section className="py-16 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div className="order-2 lg:order-1">
              <img
                src="/images/slides/slide-1-problem.png"
                alt="Managing care shouldn't be this hard"
                className="w-full rounded-2xl shadow-lg"
                draggable={false}
              />
            </div>
            <div className="order-1 lg:order-2 space-y-6">
              <h2 className="text-3xl sm:text-4xl font-bold text-gray-900">
                Managing Care Shouldn't Be <span className="text-blue-600">This Hard</span>
              </h2>
              <p className="text-lg text-gray-600 leading-relaxed">
                Juggling paperwork, medication schedules, staff coordination, and compliance requirements overwhelms even the best care teams. HomeLogic360 eliminates the chaos.
              </p>
              <div className="flex items-center gap-4">
                <button
                  onClick={() => navigate('/features')}
                  className="bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700 transition-all flex items-center gap-2"
                >
                  See How We Help <ArrowRight className="w-4 h-4" />
                </button>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Features Section */}
      <section className="py-20 bg-gray-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <h2 className="text-4xl font-bold text-gray-900 mb-4">Everything You Need</h2>
            <p className="text-xl text-gray-600 max-w-2xl mx-auto">
              A comprehensive suite of tools to manage every aspect of your care facility
            </p>
          </div>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {features.map((feature, index) => (
              <div
                key={index}
                className="bg-white p-6 rounded-xl border border-gray-200 hover:border-gray-300 hover:shadow-lg transition-all group"
              >
                <div className={`w-12 h-12 rounded-lg bg-gradient-to-br ${feature.color} flex items-center justify-center mb-4 group-hover:scale-110 transition-transform`}>
                  <feature.icon className="w-6 h-6 text-white" />
                </div>
                <h3 className="text-xl font-semibold text-gray-900 mb-2">{feature.title}</h3>
                <p className="text-gray-600">{feature.description}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Resident Care Showcase */}
      <section className="py-16 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div className="space-y-6">
              <h2 className="text-3xl sm:text-4xl font-bold text-gray-900">
                Resident Care, <span className="text-cyan-600">Made Simple</span>
              </h2>
              <p className="text-lg text-gray-600 leading-relaxed">
                From resident profiles to medication tracking, vital sign monitoring to appointment calendars &mdash; everything is connected in one intuitive dashboard.
              </p>
              <ul className="space-y-3">
                {['Comprehensive resident profiles', 'Automated medication scheduling', 'Real-time vital sign tracking', 'Family communication portal'].map((item) => (
                  <li key={item} className="flex items-center gap-3 text-gray-700">
                    <CheckCircle className="w-5 h-5 text-cyan-500 flex-shrink-0" />
                    <span>{item}</span>
                  </li>
                ))}
              </ul>
            </div>
            <div>
              <img
                src="/images/slides/slide-6-features-resident.png"
                alt="Resident care made simple"
                className="w-full rounded-2xl shadow-lg"
                draggable={false}
              />
            </div>
          </div>
        </div>
      </section>

      {/* Modules Section with Image */}
      <section className="py-20 bg-gray-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12 items-center mb-12">
            <div>
              <img
                src="/images/slides/slide-7-features-operations.png"
                alt="Streamline operations - every module you need"
                className="w-full rounded-2xl shadow-lg"
                draggable={false}
              />
            </div>
            <div className="space-y-6">
              <h2 className="text-3xl sm:text-4xl font-bold text-gray-900">Complete Module Suite</h2>
              <p className="text-lg text-gray-600 leading-relaxed">
                Access all the modules you need to run your facility efficiently &mdash; from staff check-ins and housekeeping to billing, analytics, and pharmacy management.
              </p>
            </div>
          </div>
          <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            {modules.map((module, index) => (
              <div
                key={index}
                className="bg-white p-4 rounded-lg border border-gray-200 hover:border-blue-300 hover:shadow-md transition-all text-center"
              >
                <module.icon className="w-8 h-8 text-[var(--theme-primary)] mx-auto mb-2" />
                <p className="text-sm font-medium text-gray-700">{module.name}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Benefits Section */}
      <section className="py-20 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <h2 className="text-4xl font-bold text-gray-900 mb-4">Why Choose HomeLogic360?</h2>
          </div>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            {benefits.map((benefit, index) => (
              <div key={index} className="text-center">
                <div className="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center mx-auto mb-4">
                  <benefit.icon className="w-8 h-8 text-white" />
                </div>
                <h3 className="text-xl font-semibold text-gray-900 mb-2">{benefit.title}</h3>
                <p className="text-gray-600">{benefit.description}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Analytics Section */}
      <section className="py-16 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div className="space-y-6">
              <h2 className="text-3xl sm:text-4xl font-bold text-gray-900">
                Smart Analytics, <span className="text-blue-600">Real-Time Insights</span>
              </h2>
              <p className="text-lg text-gray-600 leading-relaxed">
                Make data-driven decisions with powerful analytics dashboards. Monitor key metrics, track trends, and receive intelligent alerts to keep your facility running at peak performance.
              </p>
              <ul className="space-y-3">
                {['Real-time performance dashboards', 'Automated compliance reports', 'Trend analysis & forecasting', 'Custom alert thresholds'].map((item) => (
                  <li key={item} className="flex items-center gap-3 text-gray-700">
                    <CheckCircle className="w-5 h-5 text-blue-500 flex-shrink-0" />
                    <span>{item}</span>
                  </li>
                ))}
              </ul>
            </div>
            <div>
              <img
                src="/images/slides/slide-8-analytics.png"
                alt="Smart analytics with real-time insights"
                className="w-full rounded-2xl shadow-lg"
                draggable={false}
              />
            </div>
          </div>
        </div>
      </section>

      {/* Medication Tracking Section */}
      <section className="py-16 bg-gray-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div className="order-2 lg:order-1">
              <img
                src="/images/slides/slide-5-features-care.png"
                alt="Resident management and medication tracking"
                className="w-full rounded-2xl shadow-lg"
                draggable={false}
              />
            </div>
            <div className="order-1 lg:order-2 space-y-6">
              <h2 className="text-3xl sm:text-4xl font-bold text-gray-900">
                Connecting Care, <span className="text-cyan-600">Simplifying Life</span>
              </h2>
              <p className="text-lg text-gray-600 leading-relaxed">
                From resident management to medication tracking, HomeLogic360 connects every aspect of care delivery in one seamless platform. Never miss a dose, appointment, or critical update again.
              </p>
              <button
                onClick={() => navigate('/register-facility')}
                className="bg-cyan-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-cyan-700 transition-all flex items-center gap-2"
              >
                Get Started Today <ArrowRight className="w-4 h-4" />
              </button>
            </div>
          </div>
        </div>
      </section>

      {/* CTA Section with Background Image */}
      <section className="relative py-24 overflow-hidden">
        <div className="absolute inset-0">
          <img
            src="/images/slides/slide-4-transform.png"
            alt=""
            className="w-full h-full object-cover"
            draggable={false}
          />
          <div className="absolute inset-0 bg-black/40"></div>
        </div>
        <div className="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center z-10">
          <h2 className="text-4xl sm:text-5xl font-bold text-white mb-4">Ready to Transform Your Facility?</h2>
          <p className="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
            Join hundreds of care facilities already using HomeLogic360 to improve operations and care quality.
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <button
              onClick={() => navigate('/register-facility')}
              className="bg-white text-blue-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition-all shadow-lg hover:shadow-xl hover:scale-105"
            >
              Start Free Trial
            </button>
            <button
              onClick={() => navigate('/register-facility')}
              className="bg-transparent border-2 border-white text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white/10 transition-all"
            >
              Schedule Demo
            </button>
          </div>
        </div>
      </section>

      {/* Footer */}
      <PublicFooter />

      <style>{`
        @keyframes blob {
          0%, 100% {
            transform: translate(0, 0) scale(1);
          }
          33% {
            transform: translate(30px, -50px) scale(1.1);
          }
          66% {
            transform: translate(-20px, 20px) scale(0.9);
          }
        }
        @keyframes gradient {
          0%, 100% {
            background-position: 0% 50%;
          }
          50% {
            background-position: 100% 50%;
          }
        }
        .animate-blob {
          animation: blob 7s infinite;
        }
        .animation-delay-2000 {
          animation-delay: 2s;
        }
        .animation-delay-4000 {
          animation-delay: 4s;
        }
        .animation-delay-6000 {
          animation-delay: 6s;
        }
        .animate-gradient {
          background-size: 200% auto;
          animation: gradient 3s linear infinite;
        }
      `}</style>
    </div>
  );
}

