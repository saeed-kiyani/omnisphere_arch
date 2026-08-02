<section class="os-section os-section-light">

    <div class="container">

        <div
            class="os-section-header"
            data-aos="fade-up">

            <span class="os-section-eyebrow">
                Our Values
            </span>

            <h2 class="os-section-title">
                Principles Behind Our Work
            </h2>

        </div>


        <div class="row g-4">

            <?php

            $values = [

                [
                    'icon' => 'bi-lightbulb',
                    'title' => 'Creativity',
                    'text' => 'We develop distinctive design ideas that bring personality and purpose to every project.'
                ],

                [
                    'icon' => 'bi-rulers',
                    'title' => 'Precision',
                    'text' => 'We pay close attention to planning, proportion, materials and architectural details.'
                ],

                [
                    'icon' => 'bi-people',
                    'title' => 'Collaboration',
                    'text' => 'We work closely with clients to understand their goals and turn their ideas into reality.'
                ],

                [
                    'icon' => 'bi-gem',
                    'title' => 'Quality',
                    'text' => 'We believe successful design should deliver lasting functionality, visual appeal and value.'
                ]

            ];

            ?>

            <?php foreach ($values as $index => $value): ?>

                <div
                    class="col-lg-3 col-md-6"
                    data-aos="fade-up"
                    data-aos-delay="<?= $index * 100; ?>">

                    <div class="os-value-card">

                        <div class="os-info-icon">

                            <i class="bi <?= e($value['icon']); ?>"></i>

                        </div>

                        <h3>
                            <?= e($value['title']); ?>
                        </h3>

                        <p>
                            <?= e($value['text']); ?>
                        </p>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

</section>