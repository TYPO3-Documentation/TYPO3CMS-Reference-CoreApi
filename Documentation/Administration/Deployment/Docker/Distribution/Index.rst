:navigation-title:

..  include:: /Includes.rst.txt
.. _docker-image-distribution-overview:

===============================================
Distributing TYPO3 Docker images for deployment
===============================================

..  include:: /Administration/Deployment/Docker/_Experimental.rst.txt

When deploying a TYPO3 site using Docker, your custom site package,
extensions, and configuration are typically bundled into a Docker image.
Before the container can be run on a production server, that image needs to
be **distributed** to the server — usually via a container registry or
manual transfer.

This guide focuses specifically on **secure image distribution options**,
which is a critical step in the overall deployment process. Running the
container and configuring the production environment (e.g., web server,
database, volumes) is considered part of the full deployment and is not
covered here.
.. _docker-image-distribution-dockerhub:

Option 1: Docker Hub (private repository)
=========================================

Docker Hub supports private repositories, which allow you to push and pull
images without exposing them publicly.

To ensure your TYPO3 Docker image remains private, follow these steps:

#.  Create a private repository in the Docker Hub web interface:

    1.  Visit https://hub.docker.com/repositories
    2.  Click "Create Repository"
    3.  Set the name (e.g. `your-image`) and make sure **"Private"** is selected

#.  Log in to Docker Hub:

    .. code-block:: bash

        docker login

#.  Tag your Docker image:

    .. code-block:: bash

        docker tag your-image yourusername/your-image:tag

#.  Push the image to the private repository:

    .. code-block:: bash

        docker push yourusername/your-image:tag

**Note:** Free Docker Hub accounts allow only a limited number of private
repositories. A paid plan may be required for production use.

.. _docker-image-distribution-ghcr:

Option 2: GitHub Container Registry (GHCR)
==========================================

If your TYPO3 project's source code is stored in a GitHub repository,
you can use the GitHub Container Registry (`ghcr.io`) to securely store
Docker images.

**Steps to distribute a TYPO3 image via GHCR:**

1.  Authenticate using a GitHub personal access token.
2.  Tag your Docker image:

    ..  code-block:: bash

        docker tag your-image ghcr.io/yourusername/your-image:tag

3.  Push the image:

    ..  code-block:: bash

        docker push ghcr.io/yourusername/your-image:tag

**Tip:** GHCR integrates well with GitHub Actions for CI/CD pipelines.

.. _docker-image-distribution-self-hosted:

Option 3: Self-hosted Docker registry
=====================================

Running your own Docker registry gives you full control over where and how
images are stored and accessed.

**Start a local registry:**

    ..  code-block:: bash

        docker run -d -p 5000:5000 --name registry registry:2

**Tag and push your image:**

    ..  code-block:: bash

        docker tag your-image localhost:5000/your-image
        docker push localhost:5000/your-image

**Note:** For production use, configure SSL encryption and authentication.

.. _docker-image-distribution-cloud:

Option 4: Cloud provider registries
===================================

If you are deploying TYPO3 to a major cloud provider, consider using their
managed container registries:

-   **Amazon ECR (Elastic Container Registry)**
-   **Google Artifact Registry**
-   **Azure Container Registry**

These registries offer high security, scalability, and tight integration
with their respective cloud services and IAM systems.

.. _docker-image-distribution-summary:

Summary: Choosing the right distribution method
===============================================

TYPO3 Docker images must be securely transferred to the target environment
before they can be deployed and run. This guide outlines trusted and
practical methods for distributing your TYPO3 image.

Choose the method that best fits your infrastructure, compliance needs,
and workflow. All methods described here are compatible with TYPO3 projects
and can be part of modern DevOps pipelines.
