<?php

namespace Twitter\Controller;

use Twitter\Http\Request;
use Twitter\Http\Response;
use Twitter\Model\TweetModel;

class TweetController extends Controller
{
    protected TweetModel $model;

    public function __construct(TweetModel $model)
    {
        $this->model = $model;
    }

    public function listTweets(): Response
    {
        return $this->render('tweet/list', [
            'tweets' => $this->model->findAll()
        ]);
    }

    public function displayForm(): Response
    {
        return $this->render('tweet/form');
    }

    public function saveTweet(Request $request): Response
    {
        // 1. Fetch the content on request
        $content = $request->getParam('content');

        // 2. Save the tweet
        $this->model->insert("Deborah", $content);

        return $this->redirect('/');
    }

    public function delete(Request $request): Response
    {
        // 1. Fetch the ID that we have to delete ($request)
        $id = $request->getParam('id');

        // 2. Delete the tweet (Model)
        $this->model->remove($id);
        return $this->redirect('/');
    }
}
