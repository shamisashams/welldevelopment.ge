//import bg from "../assets/images/bg/3.png";
//import img1 from "../assets/images/other/3.png";
import { FaCalendarAlt } from "react-icons/fa";
//import { Link } from "react-router-dom";
import { Link, usePage } from '@inertiajs/inertia-react'
import { MainButton, Pagination } from "../components/Shared";
import { blogs } from "../components/Data";
import { BlogBox } from "../components/ProjectBoxes";
import React from "react";
import Layout from "../Layouts/Layout";

const Blogs = ({seo}) => {

    const {last_blog,blogs} = usePage().props;

    const renderHTML = (rawHTML) =>
        React.createElement("p", {
            dangerouslySetInnerHTML: { __html: rawHTML },
        });

  return (
      <Layout seo={seo}>
          <div
              className="bg-fixed bg-cover bg-center pb-20"
              style={{ backgroundImage: `url('/client/assets/images/bg/3.png')` }}
          >
              <div className="wrapper">
                  <svg className="dashedStroke" viewBox="0 0 960 300">
                      <text text-anchor="middle" x="30%" y="50%" className="bold">
                          ბლოგი
                      </text>
                  </svg>
                  <div className="flex items-center justify-start sm:-mt-20 -mt-10 pb-32 flex-col lg:flex-row">
                      <div className="max-w-xl rounded-xl lg:mr-10 mb-10 lg:mb-0 h-fit overflow-hidden">
                          <img src={last_blog.latest_image?last_blog.latest_image.full_url:null} alt="" />
                      </div>
                      <div className="lg:max-w-2xl">
                          <div className="bold">
                              {last_blog.title}
                          </div>
                          <div className="opacity-50 text-sm mt-1 mb-5 ">
                              <FaCalendarAlt className="inline-block mr-1 mb-1" /> {last_blog.formatted_date}
                          </div>
                          <p className="mb-10">
                              {last_blog.short_description}
                          </p>
                          <Link href={route('client.blog.show',last_blog.slug)}>
                              <MainButton text="ნახე სრულად" />
                          </Link>
                      </div>
                  </div>
                  <div className="grid xl:grid-cols-4 lg:grid-cols-3 sm:grid-cols-2 gap-y-10 gap-x-5 pb-5">
                      {blogs.data.map((item, index) => {
                          return (
                              <BlogBox
                                  key={index}
                                  link={route('client.blog.show',item.slug)}
                                  img={item.latest_image?item.latest_image.full_url:null}
                                  title={item.title}
                                  para={item.short_description}
                                  date={item.formatted_date}
                              />
                          );
                      })}
                  </div>
                  <Pagination data={blogs.links} />
              </div>
          </div>
      </Layout>

  );
};

export default Blogs;
