-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 24 Paź 2023, 00:45
-- Wersja serwera: 10.4.22-MariaDB
-- Wersja PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `project_pai`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `booking`
--

CREATE TABLE `booking` (
  `book_id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_date` date NOT NULL,
  `book_start` date NOT NULL,
  `book_end` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `countries`
--

CREATE TABLE `countries` (
  `country_id` int(11) NOT NULL,
  `country_name` varchar(60) COLLATE utf16_polish_ci NOT NULL,
  `country_desc` text COLLATE utf16_polish_ci NOT NULL,
  `country_code` varchar(2) COLLATE utf16_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_polish_ci;

--
-- Zrzut danych tabeli `countries`
--

INSERT INTO `countries` (`country_id`, `country_name`, `country_desc`, `country_code`) VALUES
(1, 'South Korea', 'South Korea, officially known as the Republic of Korea, is a vibrant and culturally rich nation located on the Korean Peninsula in East Asia. Its culture is a captivating blend of tradition and modernity, creating a unique and dynamic identity.', 'KR'),
(2, 'Japan', 'Japan, an island nation in East Asia, boasts a culture that\'s a captivating fusion of tradition and innovation. Its unique cultural elements have had a profound influence on the world.', 'JP'),
(3, 'China', 'A vast and diverse country in East Asia, is celebrated for its rich and multifaceted culture, which has evolved over thousands of years. Its cultural heritage is deeply rooted in tradition and has significantly influenced the world.', 'CN'),
(4, 'Taiwan', 'An island nation in East Asia, is a place of vibrant and diverse culture deeply influenced by its unique history and geographical location. Its culture is a dynamic blend of traditional Chinese heritage and modern innovations.', 'TW'),
(5, 'Vietnam', 'Located in Southeast Asia, is a nation with a rich and diverse cultural heritage deeply intertwined with its history and geography. Its culture reflects a unique blend of tradition, innovation, and resilience.', 'VN'),
(6, 'Cambodia', 'ocated in Southeast Asia, is a nation with a rich cultural heritage deeply intertwined with its history, religion, and stunning architectural wonders. Its culture reflects a unique blend of ancient traditions and the enduring spirit of its people.', 'KH'),
(7, 'Thailand', 'Southeast Asian nation, is renowned for its rich and vibrant culture, which seamlessly combines traditional heritage with modern influences. Its culture is characterized by a deep appreciation for spirituality, art, and hospitality.', 'TH'),
(8, 'Laos', 'A landlocked country in Southeast Asia, possesses a rich and diverse culture deeply influenced by its history, religion, and breathtaking natural landscapes. Its culture is characterized by its deep spirituality, traditions, and a strong connection to the environment.', 'LA'),
(9, 'Bangladesh', 'A South Asian nation, boasts a diverse and vibrant culture deeply rooted in its history, traditions, and the resilience of its people. Its culture is characterized by a rich blend of heritage, art, music, and a strong sense of community.', 'BD'),
(10, 'Bhutan', 'A small Himalayan kingdom in South Asia, is celebrated for its unique and rich culture, deeply rooted in its history, Buddhism, and its commitment to preserving tradition. Bhutan\'s culture is marked by a deep sense of spirituality, reverence for nature, and a unique approach to modernization.', 'BT'),
(11, 'Malaysia', 'A Southeast Asian nation, is celebrated for its diverse and multicultural society, which has created a vibrant and dynamic cultural tapestry. The country\'s culture reflects a harmonious blend of traditions, religions, and influences from various ethnic communities.', 'MY'),
(12, 'Singapore', 'A city-state in Southeast Asia, is celebrated for its unique and diverse culture, a testament to its history as a melting pot of different ethnicities and traditions. The culture of Singapore is characterized by a harmonious blend of influences from its Chinese, Malay, Indian, and Western roots.', 'SG'),
(13, 'Mongolia', 'A landlocked country in East Asia, is known for its unique and nomadic culture, deeply rooted in its history, vast landscapes, and the enduring spirit of its people. Mongolian culture is characterized by its strong ties to the nomadic way of life, ancient traditions, and deep respect for nature.', 'MN'),
(14, 'Nepal', 'Nestled in the Himalayas in South Asia, is renowned for its rich and diverse culture deeply intertwined with its breathtaking natural landscapes and deep-rooted spiritual traditions. The culture of Nepal is characterized by its profound connection to the mountains, religious heritage, and vibrant traditions.', 'NP'),
(15, 'India', 'A vast and diverse South Asian nation, is celebrated for its rich and multifaceted culture, one of the world\'s oldest and most complex. Its culture is a captivating fusion of ancient traditions, spiritual depth, and modern innovation.', 'IN'),
(16, 'Myanmar', 'A diverse Southeast Asian nation, is celebrated for its rich and multifaceted culture deeply rooted in its history, spirituality, and the enduring traditions of its people. Myanmar\'s culture is characterized by its deep connection to Buddhism, a reverence for tradition, and a complex blend of ethnicities.', 'MM');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `places`
--

CREATE TABLE `places` (
  `place_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `city` varchar(70) COLLATE utf16_polish_ci NOT NULL,
  `city_desc` text COLLATE utf16_polish_ci NOT NULL,
  `pricePerDay` double NOT NULL,
  `cityIMG` varchar(255) COLLATE utf16_polish_ci NOT NULL,
  `location_offset` varchar(255) COLLATE utf16_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_polish_ci;

--
-- Zrzut danych tabeli `places`
--

INSERT INTO `places` (`place_id`, `country_id`, `city`, `city_desc`, `pricePerDay`, `cityIMG`, `location_offset`) VALUES
(1, 1, 'Seoul', 'The capital and largest city of South Korea, Seoul is a bustling metropolis with a perfect blend of modernity and tradition. You can explore ancient palaces, vibrant markets, and enjoy the thriving K-pop culture. Don\'t miss the stunning Bukchon Hanok Village and the futuristic Dongdaemun Design Plaza.', 89, 'https://cdn.britannica.com/57/75757-050-122EC2ED/Changgyong-Palace-background-Seoul.jpg', '0.3348477730617227, 0.3029382127122646 '),
(2, 1, 'Busan', 'South Korea\'s second-largest city, Busan, is known for its beautiful beaches, such as Haeundae and Gwangalli. The city also offers a bustling fish market, historical temples, and the famous Busan International Film Festival. It\'s a great place to experience a more relaxed coastal lifestyle.', 78, 'https://media.timeout.com/images/105996093/image.jpg', '0.7763082517192346, 0.7474384502159604 '),
(3, 1, 'Jeju City', 'Located on Jeju Island, Jeju City is a popular destination for nature lovers. Explore the unique volcanic landscapes, stunning waterfalls, and the picturesque Hallasan National Park. The island is also famous for its lava tubes and lava caves.', 83, 'https://upload.wikimedia.org/wikipedia/commons/f/fd/Jeju_-_Hallasan.JPG', '0.1508593298199571, 1.0096977845155741'),
(4, 1, 'Incheon', 'Incheon, a port city near Seoul, is renowned for its modern developments and transportation hub, including Incheon International Airport. You can visit Chinatown, Wolmido Island, and the Freedom Park, which commemorates the Incheon landing during the Korean War.', 82, 'https://www.insideasiatours.com/sites/default/files/2021-08/Songdo-Central-Park-Incheon.jpg', '0.21344614143090695, 0.3293068708692635 '),
(5, 2, 'Tokyo', 'Japan\'s bustling capital, Tokyo is a city that seamlessly blends the ultramodern with the traditional. Explore high-tech districts like Shibuya and Akihabara, visit historic temples like Senso-ji, and savor world-class cuisine. Tokyo is a city of constant excitement and innovation.', 125, 'https://www.ciee.org/sites/default/files/images/2023-04/tokyo-city-neon-lights.jpg', '0.6393927629541526, 0.7091812231000516'),
(6, 2, 'Kyoto', 'Kyoto is the epitome of traditional Japan, with its historic temples, tea houses, and beautiful gardens. It\'s famous for the stunning Kinkaku-ji (Golden Pavilion) and Fushimi Inari Shrine. Don\'t miss the opportunity to experience a traditional tea ceremony in this cultural treasure.', 103, 'https://static.independent.co.uk/s3fs-public/thumbnails/image/2018/02/23/18/kyoto-main.jpg?width=1200', '0.3891072953113708, 0.7457472661361615'),
(7, 2, 'Osaka', 'Osaka is known for its vibrant street food scene and lively atmosphere. Visit Osaka Castle, explore the entertainment district of Dotonbori, and try the city\'s iconic street foods like takoyaki and okonomiyaki. Osaka is often called \'Japan\'s Kitchen.\'', 86, 'https://a.travel-assets.com/findyours-php/viewfinder/images/res70/477000/477580-Osaka.jpg', '0.36097384236894686, 0.7741617372600246 '),
(8, 2, 'Hiroshima', 'Hiroshima is a city with a poignant history, having been largely destroyed by an atomic bomb during World War II. The Hiroshima Peace Memorial, also known as the Atomic Bomb Dome, is a UNESCO World Heritage Site. The Peace Memorial Park and Museum provide a moving experience and a message of peace.', 85, 'https://upload.wikimedia.org/wikipedia/commons/f/fd/Atomic_Bomb_Dome_and_Motoyaso_River%2C_Hiroshima%2C_Northwest_view_20190417_1.jpg', '0.19217312471440334, 0.7817389295597214 '),
(9, 3, 'Beijing', 'As the capital of China, Beijing is a city steeped in history and culture. Explore the iconic Forbidden City, visit the historic Temple of Heaven, and walk along the Great Wall of China. Beijing also offers a glimpse into China\'s modernity with its skyscrapers and contemporary art scenes.', 78, 'https://cdn.britannica.com/03/198203-050-138BB1C3/entrance-Gate-of-Divine-Might-Beijing-Forbidden.jpg', '0.6762200282087447, 0.42450097281875754 '),
(10, 3, 'Shanghai', 'Shanghai is China\'s economic hub and a bustling metropolis that seamlessly combines the old and the new. Wander along the historic Bund waterfront, admire the futuristic skyline in the Pudong district, and explore the vibrant neighborhoods like Tianzifang. Shanghai offers a taste of China\'s cosmopolitan side.', 102, 'https://cdn.britannica.com/08/187508-050-D6FB5173/Shanghai-Tower-Gensler-San-Francisco-world-Oriental-2015.jpg', '0.7627268453220498, 0.6707074336126236 '),
(11, 3, 'Xi\'an', 'Xi\'an is known for its ancient history and the famous Terracotta Army. Explore the city walls, visit the Big Wild Goose Pagoda, and experience the vibrant Muslim Quarter. Xi\'an offers a journey through China\'s ancient past.', 85, 'https://english.news.cn/20230511/5d0951d6f34c46d5a1ecd8e676a866b3/89a9de9e945040a8a2b28fff0b6781ae.jpg', '0.6122802068641279, 0.6065911677808877 '),
(12, 3, 'Chengdu', 'Chengdu, the capital of Sichuan Province, is famous for its spicy cuisine and as the home of the giant panda. Visit the Chengdu Research Base of Giant Panda Breeding, explore historic sites like Wuhou Shrine, and enjoy Sichuan hotpot.', 76, 'https://media.cntraveler.com/photos/5b1a9b8408618014c567f2f2/16:9/w_4000,h_2250,c_limit/Chengdu%20China_GettyImages-510901343.jpg', '0.4787588152327222, 0.6655781323460848 '),
(13, 4, 'Taipei', 'The capital of Taiwan, Taipei is a vibrant metropolis known for its towering skyscrapers, bustling night markets, and historic temples. Must-visit attractions include the iconic Taipei 101, the National Palace Museum, Longshan Temple, and the lively Shilin Night Market.', 86, 'https://res.klook.com/image/upload/fl_lossy.progressive,w_800,c_fill,q_85/Taipei_CP1125X624_1.jpg', '0.6252504500170222, 0.25251054435038756 '),
(14, 4, 'Taichung', 'Taichung is often considered the cultural capital of Taiwan, with a thriving arts and cultural scene. It\'s home to the National Taiwan Museum of Fine Arts, and the Rainbow Village, a colorful and artistic village. The city also offers beautiful parks and gardens, like Calligraphy Greenway and Taichung Park.', 56, 'https://cktravels.com/wp-content/uploads/2019/05/IMG_5548.jpg', '0.39812956005357397, 0.38728854290475456 '),
(15, 4, 'Kaohsiung', 'Kaohsiung, located in southern Taiwan, is a city known for its vibrant arts scene, beautiful parks, and scenic waterfront. Explore Lotus Pond, visit the Pier-2 Art Center, and enjoy local street food along Liuhe Night Market.', 58, 'https://warmcheaptrips.com/wp-content/uploads/2020/05/Lorus-Pond-1127x800.jpg', '0.22444887949329, 0.6727007751375317 '),
(16, 4, 'Tainan', 'Tainan is one of Taiwan\'s oldest cities with a rich history. Visit Chihkan Tower, Anping Fort, and Koxinga Shrine. Don\'t miss the opportunity to savor Tainan\'s famous street food and traditional snacks.', 66, 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/07/44/a4/76/caption.jpg?w=1200&h=-1&s=1', '0.21108882714249894, 0.5141384238971 '),
(17, 5, 'Hanoi', 'The capital and largest city of Vietnam, Hanoi is a blend of old-world charm and modern vitality. Explore the historic Old Quarter, visit Hoan Kiem Lake and Ngoc Son Temple, and delve into the country\'s history at the Ho Chi Minh Mausoleum. Hanoi is also famous for its street food, offering delicious and affordable culinary delights.', 73, 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1b/33/f7/12/caption.jpg?w=700&h=-1&s=1', '0.48853412904046223, 0.1675594556558742 '),
(18, 5, 'Ho Chi Minh City', 'As the largest city in Vietnam, Ho Chi Minh City is a bustling, dynamic metropolis. Explore the War Remnants Museum, visit the Cu Chi Tunnels, and take a stroll along the busy streets of District 1. The city also offers a vibrant nightlife scene and numerous shopping opportunities.', 78, 'https://content.r9cdn.net/rimg/dimg/f0/b1/54455949-city-18144-167c85df43f.jpg?width=1366&height=768&xhint=1159&yhint=754&crop=true', '0.6322206375817746, 0.8296550029405945 '),
(19, 5, 'Hoi An', 'Hoi An is a charming and well-preserved ancient town known for its lantern-lit streets, historic architecture, and tailor shops. Explore the Old Town, visit the Japanese Covered Bridge, and enjoy the local cuisine.', 76, 'https://static.vinwonders.com/2022/07/hoi-an-ancient-town-3-1.jpg', '0.8437700722919508, 0.5288125460301876 '),
(20, 5, 'Da Nang', 'Da Nang is a coastal city with beautiful beaches and a growing reputation as a tourist destination. Explore the Marble Mountains, visit My Khe Beach, and take a day trip to the ancient town of Hoi An.', 67, 'https://res.klook.com/image/upload/fl_lossy.progressive,w_800,c_fill,q_85/destination/ur2mrg23d91mex03l4mw.jpg', '0.8020319658578711, 0.5082493974625749 '),
(21, 6, 'Phnom Penh', 'Phnom Penh, the capital of Cambodia, is a city that has risen from a troubled history to become a vibrant and lively place. Visit the Royal Palace, the Silver Pagoda, and the Tuol Sleng Genocide Museum to learn about Cambodia\'s past. The city also offers a range of dining and entertainment options.', 69, 'https://lp-cms-production.imgix.net/2019-06/iStock_000031715564Medium.jpg?sharp=10&vib=20&w=1200&w=600&h=400', '0.45665904085324877, 0.6978582217803003'),
(22, 6, 'Siem Reap', 'Siem Reap is a gateway to the world-famous Angkor Wat temple complex, a UNESCO World Heritage Site. Explore the Angkor Archaeological Park with its ancient temples, including Bayon and Ta Prohm. Siem Reap also offers a lively night market and a thriving arts and culture scene.', 64, 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/15/33/fc/e0/siem-reap.jpg?w=700&h=500&s=1', '0.32727554719883634, 0.386460706190218'),
(23, 6, 'Battambang', 'Battambang is a tranquil and picturesque city known for its French colonial architecture, beautiful countryside, and artistic community. Take a ride on the Bamboo Train, explore Phare Ponleu Selpak (an arts center), and visit the historic temples and museums.', 61, 'https://ychef.files.bbci.co.uk/1280x720/p0fcjrrd.jpg', '0.126731132034497, 0.386460706190218'),
(24, 6, 'Kampot', 'Kampot is a small, riverside town that offers a laid-back atmosphere and stunning natural surroundings. Explore the picturesque Bokor Hill Station, enjoy a boat trip along the Preaek Tuek Chhu River, and sample the local specialty, Kampot pepper. Nearby Kep is also known for its coastal beauty and crab market', 59, 'https://cdn.internationalliving.com/wp-content/uploads/2019/05/Kampot-Feature.jpg', '0.27552214973707134, 0.9436983656672074'),
(25, 7, 'Bangkok', 'The capital and largest city of Thailand, Bangkok is a vibrant metropolis that offers a mix of ancient temples, modern skyscrapers, and bustling markets. Visit the Grand Palace, Wat Pho, and Wat Arun, explore the historic district of Rattanakosin Island, and experience the vibrant street life of Khao San Road.', 46, 'https://a.cdn-hotels.com/gdcs/production172/d459/3af9262b-3d8b-40c6-b61d-e37ae1aa90aa.jpg', '0.3878424650509691, 0.46818290713766514'),
(26, 7, 'Chiang Mai', 'Located in the mountainous region of northern Thailand, Chiang Mai is known for its rich cultural heritage and beautiful natural surroundings. Explore historic temples like Wat Phra Singh, take part in traditional Thai cooking classes, and visit the famous Night Bazaar. The city is also a gateway to the nearby jungles and hill tribes.', 49, '', '0.20528931504837342, 0.11764503347165173'),
(27, 7, 'Phuket', 'Phuket is Thailand\'s largest island and a popular beach destination. Relax on the beautiful beaches, explore Old Phuket Town, and enjoy water activities like snorkeling and diving. The island offers a vibrant nightlife scene.', 59, '', '0.11816167527440735, 0.8232438501413044'),
(28, 7, 'Krabi', 'Krabi is known for its stunning limestone karsts, clear waters, and outdoor adventures. Visit Railay Beach, go rock climbing, explore the Thung Teao Forest Natural Park, and take boat trips to nearby islands like Phi Phi.', 49.99, '', '0.20114037982104171, 0.8413361274918084'),
(29, 8, 'Vientiane', 'Vientiane is the capital and largest city of Laos. Despite its status, it maintains a laid-back atmosphere. Explore the serene Wat Pha That Luang, stroll along the Mekong River promenade, and visit the Buddha Park (Xieng Khuan). The city also offers French colonial architecture, vibrant markets, and delicious Lao cuisine.', 76, '', '0.34413062339980827, 0.4996025093522377'),
(30, 8, 'Luang Prabang', 'Luang Prabang is a UNESCO World Heritage Site known for its well-preserved traditional architecture, Buddhist temples, and serene atmosphere. Explore the Royal Palace Museum, visit the sacred Kuang Si Waterfall, and witness the daily almsgiving ceremony. The town is surrounded by stunning natural beauty and the Mekong River', 72, '', '0.289965257702042, 0.3749262991924659'),
(31, 8, 'Pakse', 'Pakse is the largest city in southern Laos and serves as a gateway to the Bolaven Plateau, famous for its coffee plantations and waterfalls. Visit the Wat Luang temple, take a scenic drive through the plateau, and explore the traditional villages of the region', 67, '', '0.7894902969147752, 0.8387218009868171'),
(32, 8, 'Savannakhet', 'Savannakhet is a charming town on the banks of the Mekong River, offering a glimpse into Lao culture and colonial history. Explore the historic district with well-preserved French colonial buildings, visit the Wat Sainyaphum temple, and enjoy the tranquil riverfront.', 65, '', '0.6691228175864058, 0.6791362519823092'),
(33, 9, 'Dhaka', 'As the capital and largest city of Bangladesh, Dhaka is a bustling metropolis with a mix of historic landmarks and modern developments. Visit Lalbagh Fort, the Star Mosque, and Ahsan Manzil for a glimpse of the city\'s history. Explore the vibrant street markets and savor delicious Bangladeshi cuisine.', 51, '', '0.5031851556155434, 0.44496640859018216'),
(34, 9, 'Chittagong', 'Chittagong is the second-largest city and the main seaport of Bangladesh. It\'s known for its beautiful coastline, rolling hills, and lush greenery. Visit Foy\'s Lake for a scenic getaway, explore the hill station of Bandarban, and experience the diverse cultures of the Chittagong Hill Tracts.', 43, '', '0.8551312524128927, 0.7381779603773482'),
(35, 9, 'Sylhet', 'Sylhet is a city in the northeastern part of Bangladesh, famous for its picturesque tea gardens, rolling hills, and numerous waterfalls. Explore the Sylhet tea estates, visit Ratnodweep, and take a journey to Jaflong, a scenic area along the border with India.', 45, '', '0.7475921672803694, 0.3162393858543532'),
(36, 9, 'Rajshahi', 'Located in the northwest of Bangladesh, Rajshahi is known for its silk industry and archaeological sites. Explore the historic Varendra Research Museum, visit the Paharpur Vihara (a UNESCO World Heritage Site), and take in the beauty of the Padma River.', 46, '', '0.15123905881819424, 0.35914839343296284'),
(37, 10, 'Thimphu', 'Thimphu is the capital and largest city of Bhutan. It\'s a blend of modernity and tradition, where you can visit iconic sites like Tashichho Dzong, the National Memorial Chorten, and the Giant Buddha Dordenma statue. Explore the vibrant local markets, and get a sense of Bhutan\'s unique cultural heritage.', 68, '', '0.2339936380902286, 0.49250183523354457'),
(38, 10, 'Paro', 'Paro is a picturesque town and the location of Bhutan\'s only international airport. It\'s surrounded by lush valleys and is famous for the stunning Taktsang Monastery, also known as the \'Tiger\'s Nest.\' You can also visit the Rinpung Dzong, National Museum, and the town\'s unique architecture.', 67, '', '0.18500938370850198, 0.5985006837605695'),
(39, 10, 'Punakha', 'Punakha, the former capital of Bhutan, is known for its beautiful Punakha Dzong, a fortress at the confluence of two rivers. The city offers a glimpse into Bhutan\'s history and culture. Don\'t miss the suspension bridge and the scenic countryside.', 56, '', '0.4191977633771992, 0.40872007191900783'),
(40, 10, 'Bumthang Valley', 'Bumthang Valley is a group of towns in central Bhutan, often considered the spiritual heart of the country. Explore the ancient monasteries, including Jambay Lhakhang and Kurje Lhakhang. Bumthang is also known for its beautiful landscapes and fertile valleys.', 55, '', '0.6420957780035553, 0.408559537719511'),
(41, 11, 'Kuala Lumpur', 'The capital and largest city of Malaysia, Kuala Lumpur is a bustling metropolis with a striking skyline. Visit the iconic Petronas Twin Towers, explore the Batu Caves, and experience the blend of cultures in areas like Chinatown and Little India. The city is also known for its vibrant street food scene.', 70, '', '0.07734955150101364, 0.577072069870814'),
(42, 12, 'Marina Bay', 'Marina Bay is the epitome of modern Singapore, with its iconic skyline, impressive architecture, and futuristic attractions. Visit the Marina Bay Sands resort, the Gardens by the Bay, and the ArtScience Museum. Enjoy the stunning views from the Singapore Flyer, and watch the nightly light and water show at the Marina Bay Sands Skypark.', 89, '', '0.5385153118486451, 0.31531579868198517'),
(43, 13, 'Ulaanbaatar', 'As the capital and largest city of Mongolia, Ulaanbaatar is the country\'s political, cultural, and economic center. Visit the Gandantegchinlen Monastery, the National Museum of Mongolia, and the Zaisan Memorial for panoramic views. The city offers a blend of modernity and traditional Mongolian culture.', 76, '', '0.600326777576765, 0.4226720517217334 '),
(44, 13, 'Tsetserleg', 'The administrative center of Arkhangai Province and a gateway to the natural beauty of the region. Visit the picturesque Zayaiin Gegeenii Monastery, explore the Tsenkher Hot Springs, and enjoy horseback riding in the surrounding countryside.', 75, '', '0.43099469957856823, 0.4591092975598139 '),
(45, 13, 'Khovd', 'A city in western Mongolia, known for its ethnic diversity and unique cultural heritage. Explore the Museum of Khovd, visit the Maazan Salaa rock paintings, and learn about the history and customs of the local ethnic groups, including Kazakh and Tuvan communities.', 68, '', '0.1458038313710789, 0.4287449260280802 '),
(46, 14, 'Kathmandu', 'As the capital and largest city of Nepal, Kathmandu is a cultural and historical hub. Explore the Kathmandu Durbar Square, Swayambhunath Stupa (also known as the Monkey Temple), and the Pashupatinath Temple. The city offers a unique blend of Hindu and Buddhist traditions', 75, '', '0.7225401803214426, 0.7237416005443285'),
(47, 14, 'Pokhara', 'A picturesque city nestled in the foothills of the Annapurna and Dhaulagiri mountain ranges. It\'s a gateway to some of Nepal\'s most beautiful treks, such as the Annapurna Circuit. Visit Phewa Lake, Devi\'s Fall, and the International Mountain Museum', 68, '', '0.5117992943943551, 0.5723125887381305'),
(48, 14, 'Bhaktapur', 'One of the three ancient cities in the Kathmandu Valley and is a UNESCO World Heritage Site. Explore the well-preserved Bhaktapur Durbar Square, Nyatapola Temple, and the 55-Window Palace. The city is famous for its rich architecture and centuries-old culture', 65, '', '0.6372402979223833, 0.6702960669656703'),
(49, 15, 'Delhi', 'The capital of India, is a city of contrasts, with a mix of ancient history and modernity. Explore historic sites like the Red Fort, Humayun\'s Tomb, and Qutub Minar. Visit the bustling streets of Old Delhi, experience the grand architecture of New Delhi, and enjoy the city\'s diverse cuisine.', 70, '', '0.30069093752883097, 0.2857300571670772'),
(50, 15, 'Jaipur', 'The capital of Rajasthan, is known as the \'Pink City\' due to its distinctive pink sandstone buildings. Explore the City Palace, the Hawa Mahal (Palace of the Winds), and the magnificent Amber Fort. Jaipur offers a rich cultural experience, including traditional music, dance, and crafts.', 67, '', '0.24356757122194134, 0.311621309981661'),
(51, 15, 'Varanasi', 'Located on the banks of the sacred Ganges River, is one of the oldest continuously inhabited cities in the world. Visit the ghats, where people gather for religious ceremonies and rituals. Explore the narrow winding streets of the old city and experience the spiritual and cultural traditions of India', 53, '', '0.5117367496855435, 0.46308409216625146'),
(52, 16, 'Bagan', 'Famous for its thousands of ancient temples and pagodas, making it one of the most significant archaeological sites in Southeast Asia. Explore the temples, enjoy hot air balloon rides over the plains, and take in the breathtaking sunsets and sunrises.', 56, '', '0.3038779138059138, 0.4059356169289928'),
(53, 16, 'Mandalay', 'Myanmar\'s cultural and religious center. Visit the Mahamuni Buddha Temple, explore the Kuthodaw Pagoda with its \'world\'s largest book,\' and climb Mandalay Hill for panoramic views of the city. The city is known for its traditional arts and crafts', 58, '', '0.409952318558643, 0.35526851394228093');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `sessions`
--

CREATE TABLE `sessions` (
  `token` varchar(64) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `expires_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `sessions`
--

INSERT INTO `sessions` (`token`, `user_id`, `expires_at`) VALUES
('0413ddcf23b63c790c5b4132be4724c4ab91fcddb150d8d44de0d6a719eab079', 9, 1698087251),
('2f85d670e319c64e61db7dd5856acacda49278ccc08aebded836f281b8c6245b', 1, 1698249758),
('3c5f6d3214888918809e1c7eb8c860148c4ea8d3075a20aba3fab2b0f49259b3', 1, 1698262736),
('40143d811796410feafc4cb5419d330b9a05add5cea85e1f469e178d363a97ae', 1, 1698248345),
('5e8f72728fe4d725b737eb9e62a06a0dfcff3e9463d10f8807dd728a4d9a21ef', 1, 1698238924),
('645185e0758944febc863a5aae72fda4f0e7a8cec25d414820e9c53ae2144c35', 1, 1698237639),
('79271cabe5c3528963222bd9c165f85bd3ad364ef8b1755e0d7eee008a9641b7', 1, 1698094040),
('8cb58cf4c21a971107b8e1b7f0f9806f7f3c4cca249fa8b575b5f898e33f966a', 2, 1698236195),
('8e1a3a3b2407a30e919f45e0979497a94b37eb2f5071f59e3d1f38179d28a3ca', 1, 1698237727),
('988ba891a306797a9cf0e4af4bffb419cd413c1e2cef47e2196756c09287c2e9', 1, 1698224536),
('9a182a3eadc8311a2f613bb8a34d2c97b4d8eaee4b8c9c7ada8e6db9df589e70', 1, 1698086206),
('b2a520d6beb63004f5041f74424f6941ba0797c51f5b2c9afc47d4bdd97ffd41', 1, 1698273718),
('b4dcae91d2ac6a9968aaa1c6cb3f493ce55c418fa0853495d76594142590799b', 1, 1698260326),
('c185eb25e0bcff1cc82ad7d2a1ba1360ac351ee6f42adbde526a40fb83735794', 1, 1698256822),
('f97941a7c955be1ab59420875375dd07d6919481d95fc05992b3bae3b4c8cedf', 1, 1698265166),
('fae291fbf59149de865487d80cb186dfeea644b13deefe428298f88a5f45656e', 1, 1698257786);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `login` varchar(30) COLLATE utf16_polish_ci NOT NULL,
  `email` varchar(255) COLLATE utf16_polish_ci NOT NULL,
  `password` varchar(255) COLLATE utf16_polish_ci NOT NULL,
  `name` varchar(50) COLLATE utf16_polish_ci NOT NULL,
  `surname` varchar(70) COLLATE utf16_polish_ci NOT NULL,
  `dob` date NOT NULL,
  `is_admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`user_id`, `login`, `email`, `password`, `name`, `surname`, `dob`, `is_admin`) VALUES
(1, 'banana', 'baba@gmail.com', '$2y$10$dt2TPPMcR2nEzLkQUWswgezEeglkBC9I7EeZvN8iYnqM2dK6Sh.aa', 'jack', 'appleson', '0000-00-00', 1),
(2, 'admin', 'admin@gmail.com', '$2y$10$gBGsV23TaWxLonyYGyJLdexmvBFFZZrMVvJcF.F54Nu4Dfpfoi1Ni', 'jack', 'apple', '0000-00-00', 1),
(3, 'testaccount1', 'ggg@gmail.com', '$2y$10$KxJP5oIr943PTSkB1YiLq.55SFaXnQnYoxJOMw7mGRhl.fWBMGTpa', 'ggg', 'gaygg', '2023-10-25', NULL),
(4, 'abd', 'b@g', '$2y$10$vISnnENoDPyEswuO1zwkMuoCknmgBf4yWqeRQCLsA99fB9MWquF5O', 'ads', 'dbadbsd', '2023-10-21', NULL),
(5, 'apple', 'apple@gmail.com', '$2y$10$8LIQ0yq5sA4aBSJPM9RdXelqKrLBiZ7fMlmr.nHrTupU9ER66DJ7q', 'x', 'x', '2023-10-05', NULL),
(6, 'pear', 'pear@g', '$2y$10$/RxdatjR46wmQIL/fA46geUHi.E6heKi99RKlDndBS9eiaU82GHoy', 'pear', 'pear', '2023-10-07', NULL),
(9, 'test', 'poopy@gmail.com', '$2y$10$Ck/Z1jXjocQNufUUusy.F.y4Q3TJSrFM9EjtT6CgiysvGSKjOtUaW', 'my pass is', 'poop', '2023-10-03', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_bookings`
--

CREATE TABLE `user_bookings` (
  `user_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `place_id` (`place_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`country_id`);

--
-- Indeksy dla tabeli `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`place_id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indeksy dla tabeli `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`token`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indeksy dla tabeli `user_bookings`
--
ALTER TABLE `user_bookings`
  ADD KEY `book_id` (`book_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `booking`
--
ALTER TABLE `booking`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT dla tabeli `places`
--
ALTER TABLE `places`
  MODIFY `place_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`place_id`) REFERENCES `places` (`place_id`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Ograniczenia dla tabeli `places`
--
ALTER TABLE `places`
  ADD CONSTRAINT `places_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `countries` (`country_id`);

--
-- Ograniczenia dla tabeli `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Ograniczenia dla tabeli `user_bookings`
--
ALTER TABLE `user_bookings`
  ADD CONSTRAINT `user_bookings_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `booking` (`book_id`),
  ADD CONSTRAINT `user_bookings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
