<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Performance Review', 'url' => route('performance-review.index')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Vertical Wizard</h4>

                    <div id="vertical-example" class="vertical-wizard">
                        {{-- untuk staf  --}}
                        <h3 class="mb-4">REVIEW OF KEY PERFORMANCE AREAS (KPA)</h3>
                        <section>
                            <form>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <p class="text-muted">
                                                Gunakan skala 1-5 untuk setiap aspek kinerja:<br>
                                                1 = Sangat Buruk | 2 = Kurang | 3 = Cukup | 4 = Baik | 5 = Sangat Baik
                                            </p>

                                            <!-- Loop untuk setiap kategori penilaian -->
                                            <div class="mb-3">
                                                <label class="fw-bold">Ownership & Responsibility</label>
                                                <p class="text-muted">
                                                    Seberapa besar kamu memiliki tanggung jawab terhadap hasil akhir
                                                    pekerjaan dan proaktif dalam mencari solusi?
                                                </p>
                                                <select class="form-select">
                                                    <option value="1">1 - Sangat Buruk</option>
                                                    <option value="2">2 - Kurang</option>
                                                    <option value="3">3 - Cukup</option>
                                                    <option value="4">4 - Baik</option>
                                                    <option value="5">5 - Sangat Baik</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="fw-bold">Creative Thinking & Exploration</label>
                                                <p class="text-muted">
                                                    Seberapa aktif kamu mencari referensi, bereksperimen dengan teknik
                                                    baru, dan mengeksplorasi ide di luar brief?
                                                </p>
                                                <select class="form-select">
                                                    <option value="1">1 - Sangat Buruk</option>
                                                    <option value="2">2 - Kurang</option>
                                                    <option value="3">3 - Cukup</option>
                                                    <option value="4">4 - Baik</option>
                                                    <option value="5">5 - Sangat Baik</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="fw-bold">Technical Skills & Execution</label>
                                                <p class="text-muted">
                                                    Seberapa baik kamu dalam menguasai software/tools yang digunakan
                                                    dalam pekerjaannya?
                                                </p>
                                                <select class="form-select">
                                                    <option value="1">1 - Sangat Buruk</option>
                                                    <option value="2">2 - Kurang</option>
                                                    <option value="3">3 - Cukup</option>
                                                    <option value="4">4 - Baik</option>
                                                    <option value="5">5 - Sangat Baik</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="fw-bold">Time Management & Consistency</label>
                                                <p class="text-muted">
                                                    Seberapa baik kamu dalam mengatur waktu antara produksi dan
                                                    eksplorasi pribadi?
                                                </p>
                                                <select class="form-select">
                                                    <option value="1">1 - Sangat Buruk</option>
                                                    <option value="2">2 - Kurang</option>
                                                    <option value="3">3 - Cukup</option>
                                                    <option value="4">4 - Baik</option>
                                                    <option value="5">5 - Sangat Baik</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="fw-bold">Collaboration & Communication</label>
                                                <p class="text-muted">
                                                    Seberapa baik kamu dalam memberikan feedback, berdiskusi dalam
                                                    brainstorming, dan berkomunikasi dalam tim?
                                                </p>
                                                <select class="form-select">
                                                    <option value="1">1 - Sangat Buruk</option>
                                                    <option value="2">2 - Kurang</option>
                                                    <option value="3">3 - Cukup</option>
                                                    <option value="4">4 - Baik</option>
                                                    <option value="5">5 - Sangat Baik</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="fw-bold">Problem Solving & Adaptability</label>
                                                <p class="text-muted">
                                                    Seberapa cepat dan efektif kamu dalam menemukan solusi saat
                                                    menghadapi kendala teknis atau kreatif?
                                                </p>
                                                <select class="form-select">
                                                    <option value="1">1 - Sangat Buruk</option>
                                                    <option value="2">2 - Kurang</option>
                                                    <option value="3">3 - Cukup</option>
                                                    <option value="4">4 - Baik</option>
                                                    <option value="5">5 - Sangat Baik</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="fw-bold">Motivation & Growth Mindset</label>
                                                <p class="text-muted">
                                                    Seberapa besar motivasi kamu untuk berkembang dan meningkatkan
                                                    kualitas outputnya secara mandiri?
                                                </p>
                                                <select class="form-select">
                                                    <option value="1">1 - Sangat Buruk</option>
                                                    <option value="2">2 - Kurang</option>
                                                    <option value="3">3 - Cukup</option>
                                                    <option value="4">4 - Baik</option>
                                                    <option value="5">5 - Sangat Baik</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </section>

                        <h3>BEHAVIORAL REVIEW</h3>
                        <section>
                            <form>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="behavior-feedback">Receptiveness to Feedback</label>
                                            <p class="text-muted">
                                                Bagaimana kamu menerima kritik atau revisi dari atasan, klien, atau
                                                rekan kerja?
                                            </p>
                                            <select class="form-control" id="behavior-feedback">
                                                <option value="1">1 - Sangat Buruk</option>
                                                <option value="2">2 - Kurang</option>
                                                <option value="3">3 - Cukup</option>
                                                <option value="4">4 - Baik</option>
                                                <option value="5">5 - Sangat Baik</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="behavior-initiative">Independence & Initiative</label>
                                            <p class="text-muted">
                                                Seberapa sering kamu menyelesaikan tugas tanpa harus diingatkan atau
                                                diarahkan secara terus-menerus?
                                            </p>
                                            <select class="form-control" id="behavior-initiative">
                                                <option value="1">1 - Sangat Buruk</option>
                                                <option value="2">2 - Kurang</option>
                                                <option value="3">3 - Cukup</option>
                                                <option value="4">4 - Baik</option>
                                                <option value="5">5 - Sangat Baik</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="behavior-discipline">Discipline & Work Ethic</label>
                                            <p class="text-muted">
                                                Apakah kamu tetap produktif dan tidak terdistraksi oleh hal lain saat
                                                jam kerja?
                                            </p>
                                            <select class="form-control" id="behavior-discipline">
                                                <option value="1">1 - Sangat Buruk</option>
                                                <option value="2">2 - Kurang</option>
                                                <option value="3">3 - Cukup</option>
                                                <option value="4">4 - Baik</option>
                                                <option value="5">5 - Sangat Baik</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="behavior-time">Time Management & Consistency</label>
                                            <p class="text-muted">
                                                Seberapa baik kamu dalam mengatur waktu antara produksi dan eksplorasi
                                                pribadi?
                                            </p>
                                            <select class="form-control" id="behavior-time">
                                                <option value="1">1 - Sangat Buruk</option>
                                                <option value="2">2 - Kurang</option>
                                                <option value="3">3 - Cukup</option>
                                                <option value="4">4 - Baik</option>
                                                <option value="5">5 - Sangat Baik</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="behavior-culture">Contribution to Team Culture</label>
                                            <p class="text-muted">
                                                Apakah kamu menunjukkan sikap suportif, memiliki semangat tim, dan
                                                membantu menciptakan lingkungan kerja yang positif?
                                            </p>
                                            <select class="form-control" id="behavior-culture">
                                                <option value="1">1 - Sangat Buruk</option>
                                                <option value="2">2 - Kurang</option>
                                                <option value="3">3 - Cukup</option>
                                                <option value="4">4 - Baik</option>
                                                <option value="5">5 - Sangat Baik</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </section>

                        <h3>REVIEW OF ACHIEVEMENTS</h3>
                        <section>
                            <form>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="achievements-pitching">Pitching / Ideation</label>
                                            <textarea class="form-control" id="achievements-pitching" rows="3"
                                                placeholder="Apakah kamu berkontribusi dalam proses pitching atau pengembangan ide kreatif?"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="achievements-project">Project Completed</label>
                                            <textarea class="form-control" id="achievements-project" rows="3"
                                                placeholder="Proyek mana yang menjadi highlight dalam periode ini?"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="achievements-process">Process Improvement / Initiative</label>
                                            <textarea class="form-control" id="achievements-process" rows="3"
                                                placeholder="Apakah kamu membuat perubahan atau sistem yang meningkatkan efisiensi workflow tim?"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="achievements-skill">Skill Development / Training</label>
                                            <textarea class="form-control" id="achievements-skill" rows="3"
                                                placeholder="Skill atau tools baru apa yang telah dipelajari dalam periode ini?"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </section>

                        <h3>PERSONAL REFLECTION & DEVELOPMENT PLAN</h3>
                        <section>
                            <form>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="reflection-achievement">Apa pencapaian yang paling kamu
                                                banggakan dalam periode ini?</label>
                                            <textarea class="form-control" id="reflection-achievement" rows="3"
                                                placeholder="Masukkan pencapaian terbaikmu"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="reflection-challenge">Apa tantangan terbesar yang kamu hadapi
                                                dalam pekerjaan, dan bagaimana kamu mengatasinya?</label>
                                            <textarea class="form-control" id="reflection-challenge" rows="3"
                                                placeholder="Ceritakan tantangan terbesar dan cara mengatasinya"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="reflection-improve">Apa satu aspek dalam pekerjaanmu yang ingin
                                                kamu tingkatkan dalam 6 bulan ke depan?</label>
                                            <textarea class="form-control" id="reflection-improve" rows="3"
                                                placeholder="Sebutkan aspek yang ingin ditingkatkan"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="reflection-skills">Skill atau tools apa yang ingin kamu
                                                pelajari untuk meningkatkan kualitas outputmu?</label>
                                            <textarea class="form-control" id="reflection-skills" rows="3"
                                                placeholder="Sebutkan skill atau tools yang ingin dipelajari"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="reflection-future">Bagaimana kamu melihat peranmu berkembang di
                                                Imajiwa dalam 1 tahun ke depan?</label>
                                            <textarea class="form-control" id="reflection-future" rows="3"
                                                placeholder="Bagikan pandanganmu tentang perkembangan peranmu"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </section>

                        {{-- untuk lead  --}}
                        <h3>COMPATIBILITY TO CORPORATE VALUES</h3>
                        <section>
                            <form>
                                <p><strong>*Filled by Team Leader</strong></p>

                                <!-- Creative & Strategic Thinking -->
                                <div class="mb-3">
                                    <label for="rating-creative">Creative & Strategic Thinking</label>
                                    <select class="form-select" id="rating-creative">
                                        <option selected disabled>Pilih Rating</option>
                                        <option value="A">A (Outstanding)</option>
                                        <option value="B+">B+ (Excellent)</option>
                                        <option value="B">B (Good)</option>
                                        <option value="C">C (Adequate)</option>
                                        <option value="D">D (Below Standard)</option>
                                    </select>
                                </div>

                                <!-- Collaboration & Teamwork -->
                                <div class="mb-3">
                                    <label for="rating-collaboration">Collaboration & Teamwork</label>
                                    <select class="form-select" id="rating-collaboration">
                                        <option selected disabled>Pilih Rating</option>
                                        <option value="A">A (Outstanding)</option>
                                        <option value="B+">B+ (Excellent)</option>
                                        <option value="B">B (Good)</option>
                                        <option value="C">C (Adequate)</option>
                                        <option value="D">D (Below Standard)</option>
                                    </select>
                                </div>

                                <!-- Ownership & Responsibility -->
                                <div class="mb-3">
                                    <label for="rating-ownership">Ownership & Responsibility</label>
                                    <select class="form-select" id="rating-ownership">
                                        <option selected disabled>Pilih Rating</option>
                                        <option value="A">A (Outstanding)</option>
                                        <option value="B+">B+ (Excellent)</option>
                                        <option value="B">B (Good)</option>
                                        <option value="C">C (Adequate)</option>
                                        <option value="D">D (Below Standard)</option>
                                    </select>
                                </div>

                                <!-- Continuous Learning & Adaptability -->
                                <div class="mb-3">
                                    <label for="rating-learning">Continuous Learning & Adaptability</label>
                                    <select class="form-select" id="rating-learning">
                                        <option selected disabled>Pilih Rating</option>
                                        <option value="A">A (Outstanding)</option>
                                        <option value="B+">B+ (Excellent)</option>
                                        <option value="B">B (Good)</option>
                                        <option value="C">C (Adequate)</option>
                                        <option value="D">D (Below Standard)</option>
                                    </select>
                                </div>

                                <!-- Overall Rating (Diinput Manual) -->
                                <div class="mb-3">
                                    <label for="overall-rating">Overall Rating</label>
                                    <select class="form-select" id="overall-rating">
                                        <option selected disabled>Pilih Rating</option>
                                        <option value="A">A (Outstanding)</option>
                                        <option value="B+">B+ (Excellent)</option>
                                        <option value="B">B (Good)</option>
                                        <option value="C">C (Adequate)</option>
                                        <option value="D">D (Below Standard)</option>
                                    </select>
                                </div>

                            </form>
                        </section>

                        <h3>DEVELOPMENT REVIEW & ACTION PLAN</h3>
                        <section>
                            <p><strong>*Filled by Team Leader</strong></p>
                            <form>
                                <!-- Key Strengths -->
                                <div class="mb-3">
                                    <label for="key-strengths" class="form-label">
                                        <strong>Key Strengths</strong> <br>
                                        Apa kekuatan utama individu ini yang harus terus dikembangkan?
                                    </label>
                                    <textarea class="form-control" id="key-strengths" rows="3" placeholder="Masukkan penilaian..."></textarea>
                                </div>

                                <!-- Areas for Improvement -->
                                <div class="mb-3">
                                    <label for="areas-improvement" class="form-label">
                                        <strong>Areas for Improvement</strong> <br>
                                        Apa area yang masih perlu diperbaiki?
                                    </label>
                                    <textarea class="form-control" id="areas-improvement" rows="3" placeholder="Masukkan penilaian..."></textarea>
                                </div>

                                <!-- Process Improvement / Initiative -->
                                <div class="mb-3">
                                    <label for="process-improvement" class="form-label">
                                        <strong>Process Improvement / Initiative</strong> <br>
                                        Apakah individu ini membuat perubahan atau sistem yang meningkatkan efisiensi
                                        workflow tim?
                                    </label>
                                    <textarea class="form-control" id="process-improvement" rows="3" placeholder="Masukkan penilaian..."></textarea>
                                </div>

                                <!-- Recommended Training or Mentorship -->
                                <div class="mb-3">
                                    <label for="recommended-training" class="form-label">
                                        <strong>Recommended Training or Mentorship</strong> <br>
                                        Apakah ada pelatihan atau mentorship yang direkomendasikan?
                                    </label>
                                    <textarea class="form-control" id="recommended-training" rows="3" placeholder="Masukkan penilaian..."></textarea>
                                </div>
                            </form>
                        </section>

                        <h3>CLOSING STATEMENT</h3>
                        <section>
                            <p>Reviewer dan individu yang dinilai dapat memberikan pernyataan singkat tentang hasil
                                review ini.</p>
                            <form>
                                <!-- Self-Reflection Statement -->
                                <div class="mb-3">
                                    <label for="self-reflection" class="form-label">
                                        <strong>Self-Reflection Statement</strong>
                                    </label>
                                    <textarea class="form-control" id="self-reflection" rows="3"
                                        placeholder="Masukkan pernyataan refleksi diri..."></textarea>
                                </div>

                                <!-- Leader’s Final Comments -->
                                <div class="mb-3">
                                    <label for="leader-comments" class="form-label">
                                        <strong>Leader’s Final Comments</strong>
                                    </label>
                                    <textarea class="form-control" id="leader-comments" rows="3"
                                        placeholder="Masukkan komentar akhir dari leader..."></textarea>
                                </div>
                            </form>
                        </section>

                        <!-- Confirm Details -->
                        <h3>Confirm Detail</h3>
                        <section>
                            <div class="row justify-content-center">
                                <div class="col-lg-6">
                                    <div class="text-center">
                                        <div class="mb-4">
                                            <i class="mdi mdi-check-circle-outline text-success display-4"></i>
                                        </div>
                                        <div>
                                            <h5>Confirm Detail</h5>
                                            <p class="text-muted">If several languages coalesce, the grammar of the
                                                resulting</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
</div>
