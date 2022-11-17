import React from "react";
import { Swiper, SwiperSlide } from "swiper/react";
import "swiper/css";
import { ActiveProject, BlogBox, ProjectBox } from "./ProjectBoxes";
import { activeProject, blogs, projects } from "./Data";
import "swiper/css/pagination";
import { Pagination } from "swiper";

export const ProjectSlider1 = ({items}) => {
  return (
    <div>
      <Swiper
        pagination={{
          dynamicBullets: true,
        }}
        modules={[Pagination]}
        grabCursor
        slidesPerView={4}
        spaceBetween={30}
        className=""
        breakpoints={{
          1200: {
            slidesPerView: 4,
          },
          900: {
            slidesPerView: 3,
          },
          500: {
            slidesPerView: 2,
          },
          0: {
            slidesPerView: 1,
          },
        }}
      >
        {items.map((item, index) => {
          return (
            <SwiperSlide key={index} className="pb-20">
              <ActiveProject img={item.latest_image?item.latest_image.full_url:null} name={item.title} link={route('client.project.show',item.slug)} />
            </SwiperSlide>
          );
        })}
      </Swiper>
    </div>
  );
};

export const ProjectSlider2 = ({items}) => {
  return (
    <div>
      <Swiper
        pagination={{
          dynamicBullets: true,
        }}
        modules={[Pagination]}
        grabCursor
        slidesPerView={4}
        spaceBetween={30}
        className=""
        breakpoints={{
          1400: {
            slidesPerView: 4,
          },
          1000: {
            slidesPerView: 3,
          },
          600: {
            slidesPerView: 2,
          },
          0: {
            slidesPerView: 1,
          },
        }}
      >
        {items.map((item, index) => {
          return (
            <SwiperSlide key={index} className="pb-20 !h-auto">
              <ProjectBox
                link={route('client.apartment.show',item.slug)}
                img={item.latest_image?item.latest_image.full_url:null}
                title={item.title}
                para={item.short_description}
                bedroom={item.bedroom}
                bathroom={item.bathroom}
                dimension={item.dimension}
                active={item.action === 1 ? true:false}
                product={item}
              />
            </SwiperSlide>
          );
        })}
      </Swiper>
    </div>
  );
};

export const BlogSlider = ({items}) => {
  return (
    <div>
      <Swiper
        pagination={{
          dynamicBullets: true,
        }}
        modules={[Pagination]}
        grabCursor
        slidesPerView={4}
        spaceBetween={30}
        className=""
        breakpoints={{
          1400: {
            slidesPerView: 4,
          },
          1000: {
            slidesPerView: 3,
          },
          600: {
            slidesPerView: 2,
          },
          0: {
            slidesPerView: 1,
          },
        }}
      >
        {items.map((item, index) => {
          return (
            <SwiperSlide key={index} className="pb-20 !h-auto">
              <BlogBox
                img={item.latest_image?item.latest_image.full_url:null}
                title={item.title}
                date={item.formatted_date}
                para={item.short_description}
                link={route('client.blog.show',item.slug)}
              />
            </SwiperSlide>
          );
        })}
      </Swiper>
    </div>
  );
};
