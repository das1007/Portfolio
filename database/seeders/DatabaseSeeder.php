<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\{Setting,Experience,Education,Skill,UpworkReview,Project};

class DatabaseSeeder extends Seeder {
    public function run(): void {
        $settings = [
            'full_name'           => 'Darshan Patel',
            'email'               => 'darshan.p1792@gmail.com',
            'phone'               => '+91 9537359691',
            'location'            => 'Surat, Gujarat, India',
            'availability_text'   => 'Available for Freelance & Full-Time',
            'available_for_work'  => '1',
            'hero_tagline'        => 'Full-Stack Developer crafting powerful digital experiences with Angular, Node.js, Laravel & AI integrations. Based in Surat, India — working worldwide.',
            'about_text'          => "Full-stack developer with <strong>5+ years of experience</strong> building scalable web applications across startups and established companies in India and France.\n\nI specialize in crafting end-to-end solutions — from pixel-perfect interfaces with <strong>Angular</strong> to robust APIs with <strong>Node.js and Laravel</strong>, and architecting efficient databases with <strong>MySQL and MongoDB</strong>.\n\nHolding an <strong>MBA in AI and Data Science</strong> from Paris, I bring a unique blend of technical depth and strategic thinking to every project.",
            'years_experience'    => '5+',
            'projects_count'      => '20+',
            'upwork_rating'       => '5.0',
            'job_success'         => '100%',
            // Social links
            'linkedin_url'        => 'https://www.linkedin.com/in/darshan-patel-925600145/',
            'github_url'          => 'https://github.com/das1007',
            'stackoverflow_url'   => 'https://stackoverflow.com/users/10190159/darshan-patel',
            'upwork_url'          => 'https://www.upwork.com/freelancers/~01dfac756e7ef38152',
            'twitter_url'         => '',
            'instagram_url'       => '',
            'youtube_url'         => '',
            'dribbble_url'        => '',
            'behance_url'         => '',
            'devto_url'           => '',
            'medium_url'          => '',
            'website_url'         => '',
            // Upwork
            'upwork_section_title'=> '5-Star Rated on Upwork',
            'upwork_section_desc' => 'I take on freelance projects worldwide through Upwork, delivering high-quality full-stack solutions with a perfect 5-star client satisfaction record.',
            // Visibility
            'show_experience'     => '1',
            'show_education'      => '1',
            'show_skills'         => '1',
            'show_upwork'         => '1',
            'show_projects'       => '1',
            'show_contact'        => '1',
            // Theme
            'accent_color'        => '#00d4ff',
            'bg_color'            => '#080c10',
            // Profile image (upload via admin)
            'profile_image'       => '',
        ];
        foreach ($settings as $k=>$v) Setting::set($k,$v);

        Experience::insert([
            ['role'=>'Part-Time Website Manager','company'=>'Simran Montreuil','location'=>'Paris, France','period_start'=>'12/2023','period_end'=>'02/2025','description'=>'Managed company website performance, security and UX.','bullets'=>json_encode(['Managed and maintained the company website ensuring optimal performance and security','Updated website content including product listings, promotions and company news','Collaborated with marketing team to implement SEO strategies, boosting site traffic','Troubleshot and resolved technical issues, minimizing downtime','Integrated new features and tools to improve overall user experience']),'tags'=>json_encode(['WordPress','SEO','PHP','MySQL','Performance']),'is_active'=>1,'sort_order'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['role'=>'Full-Stack Developer','company'=>'Credence Technologies','location'=>'Surat, India','period_start'=>'12/2021','period_end'=>'08/2023','description'=>'Built scalable web apps using Angular and Node.js.','bullets'=>json_encode(['Integrated third-party APIs to enhance functionality and UX','Performed code reviews ensuring quality and consistency','Designed responsive front-end interfaces with Angular','Built and managed APIs with Node.js and Express.js','Managed MySQL and MongoDB with security and performance optimization']),'tags'=>json_encode(['Angular','Node.js','Express.js','MySQL','MongoDB','REST API']),'is_active'=>1,'sort_order'=>2,'created_at'=>now(),'updated_at'=>now()],
            ['role'=>'Web Developer','company'=>'Sparkle Infotech','location'=>'Surat, India','period_start'=>'08/2020','period_end'=>'10/2021','description'=>'Developed web applications with PHP and MySQL.','bullets'=>json_encode(['Developed and maintained web applications using PHP and MySQL','Collaborated with teams to translate requirements into functional features','Designed databases ensuring data integrity and performance','Implemented user authentication and authorization']),'tags'=>json_encode(['PHP','MySQL','JavaScript','HTML/CSS']),'is_active'=>1,'sort_order'=>3,'created_at'=>now(),'updated_at'=>now()],
            ['role'=>'Web Developer','company'=>'Netsol IT Solution PVT LTD','location'=>'Surat, India','period_start'=>'12/2019','period_end'=>'06/2020','description'=>'Front-end and back-end development with focus on performance.','bullets'=>json_encode(['Hands-on front-end and back-end web development','Created visually appealing user interfaces','Conducted code reviews and implemented bug fixes','Optimized code for improved performance']),'tags'=>json_encode(['PHP','jQuery','HTML/CSS','MySQL']),'is_active'=>1,'sort_order'=>4,'created_at'=>now(),'updated_at'=>now()],
        ]);

        Education::insert([
            ['degree'=>'MBA in AI & Data Science','institution'=>'Ascencia Business School — Collège De Paris','location'=>'Paris, France','period_start'=>'09/2023','period_end'=>'06/2024','emoji'=>'🎓','badges'=>json_encode(['AI','Data Science','Machine Learning','Analytics']),'is_active'=>1,'sort_order'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['degree'=>'MCA — Master of Computer Applications','institution'=>'Uka Tarsadia University','location'=>'Surat, India','period_start'=>'08/2018','period_end'=>'07/2020','emoji'=>'💻','badges'=>json_encode(['Software Dev','System Design','Database']),'is_active'=>1,'sort_order'=>2,'created_at'=>now(),'updated_at'=>now()],
            ['degree'=>'BCA — Bachelor of Computer Applications','institution'=>'Z.S.Patel College — VNSGU','location'=>'Surat, India','period_start'=>'06/2015','period_end'=>'02/2018','emoji'=>'📱','badges'=>json_encode(['Programming','Databases','Web Dev']),'is_active'=>1,'sort_order'=>3,'created_at'=>now(),'updated_at'=>now()],
        ]);

        Skill::insert([
            ['group_name'=>'frontend','group_label'=>'Frontend','items'=>json_encode(['Angular','Vue.js','React','HTML5 / CSS3','JavaScript','TypeScript','Bootstrap','jQuery']),'is_active'=>1,'sort_order'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['group_name'=>'backend','group_label'=>'Backend','items'=>json_encode(['Node.js','Express.js','PHP','Laravel','Python','REST APIs','GraphQL','WebSockets']),'is_active'=>1,'sort_order'=>2,'created_at'=>now(),'updated_at'=>now()],
            ['group_name'=>'database','group_label'=>'Database & Cloud','items'=>json_encode(['MySQL','MongoDB','SQL','AWS EC2','AWS S3','AWS CloudFront','AWS Lambda','Firebase']),'is_active'=>1,'sort_order'=>3,'created_at'=>now(),'updated_at'=>now()],
            ['group_name'=>'tools','group_label'=>'Tools & Other','items'=>json_encode(['Git / GitHub / GitLab','Linux OS','WordPress','Docker','Data Science','API Integration','Agile/Scrum','Code Review']),'is_active'=>1,'sort_order'=>4,'created_at'=>now(),'updated_at'=>now()],
        ]);

        UpworkReview::insert([
            ['reviewer'=>'Upwork Client','project_type'=>'Full-Stack Project','review_text'=>'Excellent developer! Darshan delivered the project on time and the code quality was outstanding. Very professional and communicative throughout.','rating'=>5,'is_active'=>1,'sort_order'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['reviewer'=>'Upwork Client','project_type'=>'API Integration','review_text'=>'Amazing work! Great understanding of requirements, fast turnaround, and the final product exceeded expectations. Highly recommend!','rating'=>5,'is_active'=>1,'sort_order'=>2,'created_at'=>now(),'updated_at'=>now()],
            ['reviewer'=>'Upwork Client','project_type'=>'Web Application','review_text'=>'Top-notch Angular and Node.js expertise. Fixed complex issues and added new features seamlessly. Will definitely hire again!','rating'=>5,'is_active'=>1,'sort_order'=>3,'created_at'=>now(),'updated_at'=>now()],
        ]);

        Project::insert([
            ['title'=>'E-Commerce Platform','company_name'=>'Credence Technologies','company_logo'=>'','description'=>'Full-stack e-commerce solution with Angular frontend and Node.js backend, integrated with payment gateways and real-time inventory management.','tags'=>json_encode(['Angular','Node.js','MySQL','Stripe','REST API']),'project_url'=>'','github_url'=>'','featured'=>1,'is_active'=>1,'sort_order'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['title'=>'AI Dashboard Analytics','company_name'=>'Freelance — Upwork','company_logo'=>'','description'=>'Real-time analytics dashboard using Python data pipelines with interactive charts, built for a SaaS startup in Paris.','tags'=>json_encode(['Python','React','Chart.js','AWS','PostgreSQL']),'project_url'=>'','github_url'=>'','featured'=>1,'is_active'=>1,'sort_order'=>2,'created_at'=>now(),'updated_at'=>now()],
            ['title'=>'Company Website Revamp','company_name'=>'Simran Montreuil','company_logo'=>'','description'=>'Complete redesign and performance optimization of a French retail company website, improving load time by 60% and organic traffic by 40%.','tags'=>json_encode(['WordPress','PHP','SEO','MySQL','Performance']),'project_url'=>'','github_url'=>'','featured'=>0,'is_active'=>1,'sort_order'=>3,'created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
