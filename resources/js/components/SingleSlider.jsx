import React, { useState, useRef } from "react";
import { Swiper, SwiperSlide } from "swiper/react";
import "swiper/css";
import "swiper/css/free-mode";
import "swiper/css/navigation";
import "swiper/css/thumbs";
import "swiper/css/pagination";
import { Pagination, FreeMode, Navigation, Thumbs } from "swiper";
import { BiChevronRight, BiChevronLeft } from "react-icons/bi";

const SingleSlider = ({ data }) => {
    const [thumbsSwiper, setThumbsSwiper] = useState(null);
    const prevRef = useRef(null);
    const nextRef = useRef(null);

    return (
        <>
            <Swiper
                spaceBetween={10}
                navigation={true}
                thumbs={{ swiper: thumbsSwiper }}
                modules={[FreeMode, Navigation, Thumbs]}
                className="w-full mb-5 "
                grabCursor
                onInit={(swiper) => {
                    swiper.params.navigation.prevEl = prevRef.current;
                    swiper.params.navigation.nextEl = nextRef.current;
                    swiper.navigation.init();
                    swiper.navigation.update();
                }}
            >
                {data.map((item, index) => {
                    return (
                        <SwiperSlide key={index}>
                            <div className="sm:h-96 h-60 w-full px-5">
                                <img
                                    alt=""
                                    src={item.full_url}
                                    className="w-full h-full object-cover"
                                />
                            </div>
                        </SwiperSlide>
                    );
                })}{" "}
                <div className="absolute left-0 top-1/2  flex items-center justify-between z-20 w-full">
                    <button
                        ref={prevRef}
                        className=" bg-white text-xs rounded-lg text-custom-dark flex items-center justify-center  transition duration-300   z-10 cursor-pointer shadow-md w-10 h-10"
                    >
                        <div>
                            <BiChevronLeft className="w-6 h-6" />
                        </div>
                    </button>
                    <button
                        ref={nextRef}
                        className="bg-white text-xs rounded-lg text-custom-dark flex items-center justify-center  transition duration-300  z-10 cursor-pointer shadow-md w-10 h-10"
                    >
                        <div>
                            <BiChevronRight className="w-6 h-6" />
                        </div>
                    </button>
                </div>
            </Swiper>

            <Swiper
                onSwiper={setThumbsSwiper}
                spaceBetween={10}
                slidesPerView={4}
                freeMode={true}
                watchSlidesProgress={true}
                modules={[FreeMode, Navigation, Thumbs]}
                className="sm:h-32 h-20 thumbnailSlider mb-14"
            >
                {data.map((item, index) => {
                    return (
                        <SwiperSlide key={index}>
                            <div className="sm:h-20 h-14">
                                <img
                                    alt=""
                                    src={item.full_url}
                                    className="h-full w-full object-cover "
                                />
                            </div>
                        </SwiperSlide>
                    );
                })}
            </Swiper>
        </>
    );
};

export default SingleSlider;
