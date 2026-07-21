<?php include 'components/header.php'; ?>

<div class="bg-gray-50">
    <div class="mx-auto bg-white shadow-sm overflow-hidden">

        <!-- ── HERO SECTION ── -->
        <section class="relative min-h-[260px] sm:min-h-[300px] lg:min-h-[340px] flex items-center overflow-hidden bg-cover bg-center">

            <!-- Background -->
            <div class="absolute inset-0 bg-[#062D42]/95 z-0">
                <div class="absolute inset-0 opacity-30 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>

                <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-brand-teal/20 rounded-full blur-[120px] -mr-40 -mt-40"></div>
                <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-brand-blue/20 rounded-full blur-[120px] -ml-40 -mb-40"></div>
            </div>

            <!-- Content -->
            <div class="relative z-10 max-w-[1440px] mx-auto px-4 sm:px-6 w-full h-full flex flex-col justify-center pt-20 pb-8">

                <h1 class="text-4xl sm:text-5xl lg:text-7xl font-semibold text-white animate-rise tracking-tight leading-tight">
                    About <span class="text-brand-teal">Us</span>
                </h1>

                <div class="h-1.5 w-20 bg-gradient-to-r from-[#008bb7] to-[#14b8a6] mt-3 rounded-full"></div>

                <nav class="mt-5 flex items-center gap-3 text-xs font-medium animate-rise [animation-delay:150ms]">
                    <a href="./" class="text-white/50 hover:text-white transition-colors">Home</a>
                    <span class="text-white/20">/</span>
                    <span class="text-white border-b border-brand-teal/50 pb-0.5">About</span>
                </nav>

            </div>

        </section>

        <!-- Brand Stripe -->
        <div class="h-2 w-full bg-gradient-to-r from-[#008bb7] to-[#14b8a6]"></div>

        <!-- ── MAIN PROFILE SECTION ── -->
        <section class="py-10 sm:py-14 lg:py-16">
            <div class="max-w-[1440px] mx-auto px-4 sm:px-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-16 items-start">

                    <!-- LEFT: Image & Quick Details -->
                    <div class="lg:col-span-5 flex flex-col gap-6 lg:gap-8">
                        <div class="relative group">
                            <div class="absolute -inset-4 rounded-[2rem] blur-xl opacity-50 group-hover:opacity-10 transition duration-500"></div>
                            <div class="relative rounded-3xl overflow-hidden shadow-xl bg-slate-100 aspect-[4/5]">
                                <img src="images/profile pic/manisha1.png"
                                    alt="Dr. Manisha Gupta"
                                    class="w-full h-full object-cover object-[center_100%]">
                            </div>
                        </div>

                        <!-- Highlights List (Desktop View Only) -->
                        <div class="hidden lg:block relative bg-gradient-to-br from-white to-slate-50 p-10 rounded-[2rem] border border-slate-200 shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden">

                            <!-- Glow Effect -->
                            <div class="absolute -top-10 -right-10 w-40 h-40 bg-brand-teal/10 rounded-full blur-3xl"></div>

                            <h3 class="text-[#042A3F] font-bold text-2xl mb-8 tracking-tight text-center relative z-10">
                                Key Achievements & Highlights
                            </h3>

                            <div class="relative pl-6">

                                <!-- Vertical Line -->
                                <div class="absolute left-2 top-0 w-[2px] h-full bg-brand-teal/60"></div>

                                <ul class="space-y-5 text-[15px] text-gray-700 leading-relaxed relative z-10">

                                    <li class="relative group">
                                        <div class="absolute -left-[7px] top-2 w-4 h-4 rounded-full bg-white border-2 border-brand-teal shadow-md group-hover:scale-125 group-hover:bg-brand-teal transition"></div>
                                        <p class="pl-4">
                                            Recipient of <strong>Global Healthcare Excellence Award (2014)</strong> for Best Physician in Mohali.
                                        </p>
                                    </li>

                                    <li class="relative group">
                                        <div class="absolute -left-[7px] top-2 w-4 h-4 rounded-full bg-white border-2 border-brand-teal shadow-md group-hover:scale-125 group-hover:bg-brand-teal transition"></div>
                                        <p class="pl-4">
                                            Received <strong>"Post Graduate Diploma in Cardiology"</strong> from Royal College of Physicians in 2017-18.
                                        </p>
                                    </li>

                                    <li class="relative group">
                                        <div class="absolute -left-[7px] top-2 w-4 h-4 rounded-full bg-white border-2 border-brand-teal shadow-md group-hover:scale-125 group-hover:bg-brand-teal transition"></div>
                                        <p class="pl-4">
                                            Done <strong>'Certified program in Diabetes Care'</strong> by Harvard Medical School in March 2016.
                                        </p>
                                    </li>

                                    <li class="relative group">
                                        <div class="absolute -left-[7px] top-2 w-4 h-4 rounded-full bg-white border-2 border-brand-teal shadow-md group-hover:scale-125 group-hover:bg-brand-teal transition"></div>
                                        <p class="pl-4">
                                            Done <strong>'Post graduate course in Diabetology'</strong> from Boston University School of Medicine in Jan 2016.
                                        </p>
                                    </li>

                                    <li class="relative group">
                                        <div class="absolute -left-[7px] top-2 w-4 h-4 rounded-full bg-white border-2 border-brand-teal shadow-md group-hover:scale-125 group-hover:bg-brand-teal transition"></div>
                                        <p class="pl-4">
                                            Done <strong>"Certified Program in Clinical Cardiology"</strong> conducted by Harvard Medical School in June 2014.
                                        </p>
                                    </li>

                                    <li class="relative group">
                                        <div class="absolute -left-[7px] top-2 w-4 h-4 rounded-full bg-white border-2 border-brand-teal shadow-md group-hover:scale-125 group-hover:bg-brand-teal transition"></div>
                                        <p class="pl-4">
                                            Completed Diploma Program by Boston University School of Medicine in <strong>"Acid Peptic Disorder and Irritable Bowel Syndrome"</strong> in March 2014.
                                        </p>
                                    </li>

                                    <li class="relative group">
                                        <div class="absolute -left-[7px] top-2 w-4 h-4 rounded-full bg-white border-2 border-brand-teal shadow-md group-hover:scale-125 group-hover:bg-brand-teal transition"></div>
                                        <p class="pl-4">
                                            Published author in reputed journals including <strong>The Lancet</strong> and <strong>Gastrointestinal Endoscopy</strong>.
                                        </p>
                                    </li>

                                    <li class="relative group">
                                        <div class="absolute -left-[7px] top-2 w-4 h-4 rounded-full bg-white border-2 border-brand-teal shadow-md group-hover:scale-125 group-hover:bg-brand-teal transition"></div>
                                        <p class="pl-4">
                                            Member of leading medical bodies including the <strong>Association of Physicians of India</strong>, <strong>Indian Medical Association</strong>, and <strong>American College of Physicians</strong>.
                                        </p>
                                    </li>

                                </ul>

                            </div>
                        </div>
                    </div>

                    <!-- RIGHT: Bio Content -->
                    <div class="lg:col-span-7 flex flex-col gap-6 lg:gap-8">

                        <div>
                            <!-- Heading -->
                            <h2
                                class="bg-gradient-to-r from-brand-sky to-brand-navy bg-clip-text text-transparent text-4xl sm:text-5xl lg:text-[50px] leading-[1.05] font-semibold tracking-tight">
                                Dr. Manisha Gupta
                            </h2>

                            <!-- Divider -->
                            <div class="w-20 h-1.5 bg-gradient-to-r from-[#74C2F9] to-[#064854] mt-5 rounded-full my-7 ml-0"></div>

                            <div class="space-y-1">
                                <p class="text-lg text-brand-blue font-medium mt-2">Senior Consultant – Internal Medicine</p>
                                <!-- Hospital Name - Same Styling -->
                                <p class="text-lg text-brand-blue font-medium">Sohana Hospital</p>
                            </div>

                            <!-- Education Tags -->
                            <div class="space-y-4 mt-4">
                                <div class="flex flex-wrap gap-2">
                                    <span class="px-4 py-2 bg-[#062D42]/5 text-[#062D42] text-xs font-bold rounded-lg border border-[#062D42]/10">M.B.B.S.</span>
                                    <span class="px-4 py-2 bg-[#062D42]/5 text-[#062D42] text-xs font-bold rounded-lg border border-[#062D42]/10">M.D. (Medicine)</span>
                                    <span class="px-4 py-2 bg-[#062D42]/5 text-[#062D42] text-xs font-bold rounded-lg border border-[#062D42]/10">MRCP I & II (W)</span>
                                    <span class="px-4 py-2 bg-[#062D42]/5 text-[#062D42] text-xs font-bold rounded-lg border border-[#062D42]/10">FACP</span>

                                </div>
                            </div>
                        </div>

                        <div class="relative bg-white/80 backdrop-blur-xl">

                            <div class="space-y-6 text-gray-700 leading-relaxed text-[16px] lg:text-[17px] relative z-10">

                                <p class="text-[17px] lg:text-[18px] leading-relaxed text-[#042A3F] font-medium">
                                    With over two decades of clinical excellence, <strong class="text-brand-teal">Dr. Manisha Gupta</strong> is a highly respected name in Internal Medicine, known for her patient-centric approach, strong diagnostic acumen, and commitment to evidence-based care.
                                </p>

                                <p>
                                    Based in Mohali, she brings together extensive experience across premier government institutions, leading private hospitals, and her own successful clinical practice.
                                </p>

                                <!-- highlight block -->
                                <div class="p-5 rounded-xl bg-gradient-to-r from-brand-teal/5 to-transparent border-l-4 border-brand-teal">
                                    <p>
                                        Dr. Gupta completed her <strong>M.B.B.S.</strong> from the prestigious
                                        <strong>King George Medical College, Lucknow</strong>,
                                        followed by an <strong>M.D. in Medicine</strong>.
                                    </p>
                                </div>

                                <p>
                                    Her clinical journey includes key roles at PGIMER Chandigarh, Government Medical College Chandigarh, Fortis Hospital Mohali, Ivy Hospital, and SGHS Superspeciality Hospital, where she currently serves as a Senior Consultant.
                                </p>

                                <!-- clinic highlight -->
                                <!-- <div class="p-5 rounded-xl bg-slate-50 border border-slate-200">
                                    <p>
                                        In 2014, she established <strong class="text-brand-blue">Dr. Manisha's Mediclinic</strong> in Mohali, where she continues to provide comprehensive outpatient care while remaining actively associated with reputed tertiary care centres.
                                    </p>
                                </div> -->

                                <!-- <p>
                                    Her expertise spans chronic disease management, including <strong>diabetes, thyroid disorders, hypertension, cardiac care</strong>, and lifestyle-related illnesses. She has further strengthened her clinical capabilities through advanced certifications from globally renowned institutions such as Harvard Medical School and Boston University.
                                </p> -->

                                <p>
                                    A passionate educator and speaker, Dr. Gupta has over 6 years of teaching experience and has actively contributed to medical education through lectures, CMEs, and academic sessions.
                                </p>

                                <p>
                                    She is also actively involved in community health awareness initiatives,
                                    regularly conducting health talks and medical camps.
                                    <br />
                                    She believes in treatment with empathy, trust and care.
                                </p>

                                <!-- closing line -->
                                <div class="mt-6 pt-4 border-t border-slate-200">
                                    <p class="font-medium text-[#042A3F]">
                                        Her dedication to excellence, continuous learning, and compassionate care has earned her recognition among peers and patients alike.
                                    </p>
                                </div>

                                <!-- Highlights List (Mobile/Tablet View Only - Shifted Here) -->
                                <div class="lg:hidden relative bg-gradient-to-br from-white to-slate-50 p-10 rounded-[2rem] border border-slate-200 shadow-lg mt-8 overflow-hidden">
                                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-brand-teal/10 rounded-full blur-3xl"></div>
                                    <h3 class="text-[#042A3F] font-bold text-2xl mb-8 tracking-tight text-center relative z-10">
                                        Key Achievements & Highlights
                                    </h3>
                                    <div class="relative pl-6">
                                        <div class="absolute left-2 top-0 w-[2px] h-full bg-brand-teal/60"></div>
                                        <ul class="space-y-5 text-[15px] text-gray-700 leading-relaxed relative z-10">
                                            <li class="relative group">
                                                <div class="absolute -left-[7px] top-2 w-4 h-4 rounded-full bg-white border-2 border-brand-teal shadow-md transition"></div>
                                                <p class="pl-4">Recipient of <strong>Global Healthcare Excellence Award (2014)</strong>.</p>
                                            </li>
                                            <li class="relative group">
                                                <div class="absolute -left-[7px] top-2 w-4 h-4 rounded-full bg-white border-2 border-brand-teal shadow-md transition"></div>
                                                <p class="pl-4">Received <strong>"Post Graduate Diploma in Cardiology"</strong> from RCP in 2017-18.</p>
                                            </li>
                                            <li class="relative group">
                                                <div class="absolute -left-[7px] top-2 w-4 h-4 rounded-full bg-white border-2 border-brand-teal shadow-md transition"></div>
                                                <p class="pl-4">Done <strong>'Certified program in Diabetes Care'</strong> by Harvard in 2016.</p>
                                            </li>
                                            <li class="relative group">
                                                <div class="absolute -left-[7px] top-2 w-4 h-4 rounded-full bg-white border-2 border-brand-teal shadow-md transition"></div>
                                                <p class="pl-4">Done <strong>'Post graduate course in Diabetology'</strong> from Boston University in 2016.</p>
                                            </li>
                                            <li class="relative group">
                                                <div class="absolute -left-[7px] top-2 w-4 h-4 rounded-full bg-white border-2 border-brand-teal shadow-md transition"></div>
                                                <p class="pl-4">Done <strong>"Certified Program in Clinical Cardiology"</strong> by Harvard in 2014.</p>
                                            </li>
                                            <li class="relative group">
                                                <div class="absolute -left-[7px] top-2 w-4 h-4 rounded-full bg-white border-2 border-brand-teal shadow-md transition"></div>
                                                <p class="pl-4">Diploma from Boston University in <strong>"Acid Peptic Disorder & IBS"</strong> in 2014.</p>
                                            </li>
                                            <li class="relative group">
                                                <div class="absolute -left-[7px] top-2 w-4 h-4 rounded-full bg-white border-2 border-brand-teal shadow-md transition"></div>
                                                <p class="pl-4">Published author in reputed journals including <strong>The Lancet</strong>.</p>
                                            </li>
                                            <li class="relative group">
                                                <div class="absolute -left-[7px] top-2 w-4 h-4 rounded-full bg-white border-2 border-brand-teal shadow-md transition"></div>
                                                <p class="pl-4">Member of leading medical bodies including <strong>API</strong>, <strong>IMA</strong>, and <strong>ACP</strong>.</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── PUBLICATIONS SECTION ── -->
        <section class="py-10 sm:py-14 bg-slate-100">
            <div class="max-w-[1440px] mx-auto px-4 sm:px-6">

                <!-- Heading -->
                <div class="text-center mb-10 px-4">
                    <h2 class="section-heading text-4xl md:text-6xl font-semibold leading-tight font-fraunces tracking-tight">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#58A9E2] to-[#064854]">
                            Publications
                        </span>
                    </h2>
                    <div class="w-20 h-1.5 bg-gradient-to-r from-[#74C2F9] to-[#064854] mx-auto mt-5 rounded-full"></div>
                </div>


                <div class="grid grid-cols-1 gap-6">
                    <!-- Publication Card 1 -->
                    <a href="https://pubmed.ncbi.nlm.nih.gov/18603159/" target="_blank" class="flex gap-6 p-6 bg-white border border-slate-200 rounded-2xl hover:border-brand-teal hover:shadow-xl transition-all group">
                        <span class="text-3xl font-black text-slate-300 group-hover:text-brand-teal transition-colors duration-300">
                            01
                        </span>
                        <div>
                            <p class="text-xs text-brand-teal font-bold mb-1 uppercase">Lancet 2008</p>
                            <h3 class="text-[#062D42] font-bold group-hover:text-brand-blue transition-colors">Cullen's and Turner's sign associated with portal hypertension.</h3>
                            <p class="text-sm text-gray-500 mt-2 italic">Chauhan S, Gupta M, Sachdeva A, D'cruz S, Kaur I.</p>
                        </div>
                    </a>

                    <!-- Publication Card 2 -->
                    <a href="https://pubmed.ncbi.nlm.nih.gov/15599004/" target="_blank" class="flex gap-6 p-6 bg-white border border-slate-200 rounded-2xl hover:border-brand-teal hover:shadow-xl transition-all group">
                        <span class="text-3xl font-black text-slate-300 group-hover:text-brand-teal transition-colors duration-300">
                            02
                        </span>
                        <div>
                            <p class="text-xs text-brand-teal font-bold mb-1 uppercase">Indian J Gastroenterol 2004</p>
                            <h3 class="text-[#062D42] font-bold group-hover:text-brand-blue transition-colors">Duodenal metastases from squamous cell carcinoma of the lung.</h3>
                            <p class="text-sm text-gray-500 mt-2 italic">Misra SP, Dwivedi M, Misra V, Dharmani S, Gupta M.</p>
                        </div>
                    </a>

                    <!-- Publication Card 3 -->
                    <a href="https://pubmed.ncbi.nlm.nih.gov/15557954/" target="_blank" class="flex gap-6 p-6 bg-white border border-slate-200 rounded-2xl hover:border-brand-teal hover:shadow-xl transition-all group">
                        <span class="text-3xl font-black text-slate-300 group-hover:text-brand-teal transition-colors duration-300">
                            03
                        </span>
                        <div>
                            <p class="text-xs text-brand-teal font-bold mb-1 uppercase">Gastrointest Endosc 2004</p>
                            <h3 class="text-[#062D42] font-bold group-hover:text-brand-blue transition-colors">Ileal varices and portal hypertensive ileopathy in patients with cirrhosis.</h3>
                            <p class="text-sm text-gray-500 mt-2 italic">Misra SP, Dwivedi M, Misra V, Gupta M.</p>
                        </div>
                    </a>

                    <!-- Publication Card 4 -->
                    <a href="https://pubmed.ncbi.nlm.nih.gov/15332043/" target="_blank" class="flex gap-6 p-6 bg-white border border-slate-200 rounded-2xl hover:border-brand-teal hover:shadow-xl transition-all group">
                        <span class="text-3xl font-black text-slate-300 group-hover:text-brand-teal transition-colors duration-300">
                            04
                        </span>
                        <div>
                            <p class="text-xs text-brand-teal font-bold mb-1 uppercase">Gastrointest Endosc 2004</p>
                            <h3 class="text-[#062D42] font-bold group-hover:text-brand-blue transition-colors">A needle embedded in stomach for 32 years.</h3>
                            <p class="text-sm text-gray-500 mt-2 italic">Misra SP, Dwivedi M, Gupta M.</p>
                        </div>
                    </a>

                    <!-- Publication Card 5 -->
                    <a href="https://pubmed.ncbi.nlm.nih.gov/15243884/" target="_blank" class="flex gap-6 p-6 bg-white border border-slate-200 rounded-2xl hover:border-brand-teal hover:shadow-xl transition-all group">
                        <span class="text-3xl font-black text-slate-300 group-hover:text-brand-teal transition-colors duration-300">
                            05
                        </span>
                        <div>
                            <p class="text-xs text-brand-teal font-bold mb-1 uppercase">Endoscopy 2004</p>
                            <h3 class="text-[#062D42] font-bold group-hover:text-brand-blue transition-colors">Endoscopic biopsies from normal-appearing terminal ileum and cecum.</h3>
                            <p class="text-sm text-gray-500 mt-2 italic">Misra SP, Dwivedi M, Misra V, Gupta M, Kunwar BK.</p>
                        </div>
                    </a>
                </div>
            </div>
        </section>

    </div>
</div>

<?php include 'components/footer.php'; ?>