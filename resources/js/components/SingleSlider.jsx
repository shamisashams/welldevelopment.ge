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
        loop
        spaceBetween={10}
        navigation={true}
        thumbs={thumbsSwiper}
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
              <div className="max-h-96 w-full">
                <img
                  alt=""
                  src={item.full_url}
                  className="mx-auto h-full object-contain"
                />
              </div>
            </SwiperSlide>
          );
        })}{" "}
        <div className="absolute left-0 top-1/2  flex items-center justify-between z-20 w-full">
          <button
            ref={prevRef}
            className="  text-xs rounded-lg text-custom-dark flex items-center justify-center  transition duration-300   z-10 cursor-pointer shadow-md w-10 h-10"
          >
            <div>
              <BiChevronLeft className="w-6 h-6" />
            </div>
          </button>
          <button
            ref={nextRef}
            className=" text-xs rounded-lg text-custom-dark flex items-center justify-center  transition duration-300  z-10 cursor-pointer shadow-md w-10 h-10"
          >
            <div>
              <BiChevronRight className="w-6 h-6" />
            </div>
          </button>
        </div>
      </Swiper>

      <Swiper
        loop
        onSwiper={setThumbsSwiper}
        spaceBetween={10}
        slidesPerView={4}
        freeMode={true}
        watchSlidesProgress={true}
        modules={[FreeMode, Navigation, Thumbs]}
        className="sm:h-32 h-20 thumbnailSlider"
      >
        {data.map((item, index) => {
          return (
            <SwiperSlide key={index}>
              <div className="h-24">
                <img
                  alt=""
                  src={item.full_url}
                  className="h-full w-full object-contain "
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
