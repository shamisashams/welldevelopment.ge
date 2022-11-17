//import bg from "../assets/images/bg/2.png";
import React from "react";
import Layout from "../Layouts/Layout";
import { Link, usePage } from '@inertiajs/inertia-react'
const renderHTML = (rawHTML) =>
    React.createElement("p", {
        dangerouslySetInnerHTML: { __html: rawHTML },
    });

const About = ({seo,page}) => {

  return (
      <Layout seo={seo}>
          <section
              className=" lg:min-h-screen bg-cover sm:bg-center flex items-center justify-start "
              style={{ backgroundImage: `url('/client/assets/images/bg/2.png')` }}
          >
              <div className="wrapper lg:pb-40 py-10">
                  <div className="xl:text-5xl sm:text-3xl text-xl bold xl:mb-8 mb-3">
                      {page.title}
                  </div>
                  <p className="opacity-50 max-w-xl">
                      {renderHTML(page.description)}
                  </p>
              </div>
          </section>
      </Layout>

  );
};

export default About;
