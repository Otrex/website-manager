<?php

$app_config = [
  'test' => getenv('TEST'),

  'env' => [
    'loader' => \App\Core\EnvLoader::class,
    'path' => __ROOT__ . '/',
  ],
  
  'templates' => [
    [
      "id" => 1,
      "title" => "AI Agency",
      "cover" => "https://useagencyai-bucket.s3.us-west-1.amazonaws.com/editor/assets/img/agency-purple.png",
      "path" => __ROOT__ ."/templates/ai-agency",
      "visible_to" => ["linkd"],
      "children" => [
        "index.html"
      ]
    ],
    [
      "id" => 2,
      "title" => "Social Media Agency",
      "cover" => "https://useagencyai-bucket.s3.us-west-1.amazonaws.com/uploads/agencies/SA360-Agency1.png",
      "path" => __ROOT__ ."/templates/social-agency",
      "visible_to" => ["linkd"],
      "children" => [
        "index.html",
        "service.html",
        "package.html",
      ]
    ],
    [
      "id" => 3,
      "title" => "Video Agency",
      "cover" => __BASE_URL__ . '/exports/images/Video-Marketing.png',
      "path" => __ROOT__ ."/templates/video-agency",
      "visible_to" => ["linkd"],
      "children" => [
        "index.html"
      ]
    ],
    [
      "id" => 4,
      "title" => "Brand Marketing Agency",
      "cover" => __BASE_URL__ . '/exports/images/CourseAgency.png',
      "path" => __ROOT__ ."/templates/brand-marketing-agency",
      "visible_to" => ["linkd"],
      "children" => [
        "index.html"
      ]
    ],
    [
      "id" => 5,
      "title" => "Web Design Agency",
      "cover" => __BASE_URL__ . '/exports/images/Web Design.png',
      "path" => __ROOT__ ."/templates/web-design-agency",
      "visible_to" => ["linkd"],
      "children" => [
        "index.html"
      ]
    ],
    [
      "id" => 6,
      "title" => "Content Marketing Agency",
      "cover" => __BASE_URL__ . '/exports/images/ContentAgency.png',
      "path" => __ROOT__ ."/templates/content-marketing-agency",
      "visible_to" => ["linkd"],
      "children" => [
        "index.html"
      ]
    ],
    [
      "id" => 7,
      "title" => "LinkedIn Agency",
      "cover" => __BASE_URL__ . '/exports/images/LinkedinAgency.png',
      "path" => __ROOT__ ."/templates/linkedin-agency",
      "visible_to" => ["linkd"],
      "children" => [
        "index.html"
      ]
    ],
  ]
];